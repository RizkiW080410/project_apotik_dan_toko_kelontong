<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pesanan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\{Repeater, Select, TextInput, DatePicker, Hidden};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\PesananResource\Pages;
use App\Filament\Admin\Resources\PesananResource\RelationManagers;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Manajemen Apotek';
    protected static ?string $navigationLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('profile_id')
                    ->relationship('profile', 'nama_lengkap')
                    ->required()
                    ->label('Pemesan'),

                Select::make('pengajuan_id')
                    ->relationship('pengajuan', 'nomor_pengajuan')
                    ->nullable()
                    ->label('Berdasarkan Pengajuan'),
                TextInput::make('nomor_pesanan')
                    ->disabled()
                    ->dehydrated(false)
                    ->label('Nomor Otomatis'),
                Forms\Components\DatePicker::make('tanggal'),
                Repeater::make('items')
                    ->label('Produk yang Dipesan')
                    ->relationship()
                    ->schema([
                        Select::make('obat_id')
                            ->label('Produk')
                            ->relationship('obat', 'nama_obat')
                            ->required(),

                        TextInput::make('qty')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->reactive()
                            ->required(),

                        TextInput::make('total')
                            ->label('Subtotal')
                            ->disabled()
                            ->dehydrated()
                            ->numeric()
                            ->default(0)
                            ->afterStateHydrated(function ($state, callable $set, $get) {
                                $qty = $get('qty') ?? 1;
                                $obat = \App\Models\Obat::find($get('obat_id'));
                                if ($obat) {
                                    $set('total', $qty * $obat->harga);
                                }
                            })
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $qty = $get('qty') ?? 1;
                                $obat = \App\Models\Obat::find($get('obat_id'));
                                if ($obat) {
                                    $set('total', $qty * $obat->harga);
                                }
                            }),
                    ])
                    ->columns(3),
                TextInput::make('total')
                    ->label('Total Harga')
                    ->disabled()
                    ->dehydrated()
                    ->numeric()
                    ->default(0)
                    ->afterStateHydrated(function (callable $set, $get) {
                        $total = collect($get('items'))->sum('total');
                        $set('total', $total);
                    })
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $get) {
                        $total = collect($get('items'))->sum('total');
                        $set('total', $total);
                    }),
                Select::make('status')
                    ->options([
                        'menunggu' => 'Menunggu',
                        'diproses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ])
                    ->default('menunggu')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_pesanan')
                    ->searchable(),
                TextColumn::make('profile.nama_lengkap')->label('Pemesan'),
                TextColumn::make('pengajuan.nomor_pengajuan')->label('Pengajuan'),
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('items_summary')
                ->label('Produk')
                ->html() // karena kita tampilkan <br>
                ->getStateUsing(function ($record) {
                    return $record->items->map(function ($item) {
                        return '<b>' . $item->obat->nama_obat . '</b> x ' . $item->qty;
                    })->implode('<br>');
                }),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                BadgeColumn::make('status')->colors([
                    'gray' => 'menunggu',
                    'warning' => 'diproses',
                    'primary' => 'dikirim',
                    'success' => 'selesai',
                    'danger' => 'dibatalkan',
                ]),
                Tables\Columns\TextColumn::make('pengajuan_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}
