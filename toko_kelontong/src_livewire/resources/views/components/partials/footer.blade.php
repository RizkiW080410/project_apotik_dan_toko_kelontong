<footer class="section-sm bg-tertiary">
	<div class="container">
        <div class="container d-flex justify-content-center">
            <a wire:navigate href="{{ route ('home') }}"> {{ $footers->name ?? '' }}</a>
        </div>
	</div>
</footer>