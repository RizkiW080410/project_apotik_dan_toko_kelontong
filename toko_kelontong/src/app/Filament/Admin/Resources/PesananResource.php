<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Pesanan;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\PesananResource\Pages;
use App\Filament\Admin\Resources\PesananResource\RelationManagers;

class PesananResource extends Resource
{
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'management Pesanan';

    protected static ?int $navigationSort = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        function recomputeTotal($set, $get) {
            $productId = $get('product_id');
            $qty = $get('qty');

            if ($productId && $qty) {
                $product = \App\Models\Product::find($productId);
                if ($product) {
                    $set('total', $product->harga * $qty);
                }
            }
        }

        return $form
            ->schema([
                Forms\Components\Select::make('pembeli_id')
                    ->relationship('pembeli', 'nama_lengkap')
                    ->required(),
                Forms\Components\TextInput::make('nomor_pesanan')
                    ->disabled()
                    ->dehydrated(false)
                    ->default(fn () => 'Akan di-generate otomatis')
                    ->label('Nomor Pesanan'),
                Forms\Components\Repeater::make('items')
                    ->label('Daftar Produk')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label('Produk')
                            ->relationship('product', 'name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($set, $get) {
                                self::recomputeTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('qty')
                            ->label('Qty')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->reactive()
                            ->afterStateUpdated(function ($set, $get) {
                                self::recomputeTotal($set, $get);
                            }),

                        Forms\Components\TextInput::make('total')
                            ->label('Total Harga')
                            ->disabled()
                            ->dehydrated()
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3)
                    ->defaultItems(1),
                Forms\Components\TextInput::make('total')
                    ->label('Total Pembayaran')
                    ->disabled()
                    ->dehydrated()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('status')
                    ->label('Status')
                    ->options([
                        'tunggu' => 'Tunggu',
                        'diproses' => 'Diproses',
                        'dikirim' => 'Dikirim',
                        'selesai' => 'Selesai',
                    ])
                    ->required(),
            ]);
    }

    private static function recomputeTotal($set, $get): void
    {
        $productId = $get('product_id');
        $qty = $get('qty');

        if ($productId && $qty) {
            $product = Product::find($productId);
            if ($product) {
                $set('total', $product->harga * $qty);
            }
        }
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pembeli.nama_lengkap')
                    ->label('Pembeli'),
                Tables\Columns\TextColumn::make('nomor_pesanan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('items.product.name')
                    ->label('product'),
                Tables\Columns\TextColumn::make('items.qty')
                    ->numeric()
                    ->label('Qty')
                    ->sortable(),
                Tables\Columns\TextColumn::make('items.total')
                    ->numeric()
                    ->label('Total')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->label('Total Pembayaran')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
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
