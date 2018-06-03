<h2>
    @if ($exception->getMessage())
        {{$exception->getMessage()}}
    @else
        Page not found.
    @endif
</h2>