<h2>
    @if ($exception->getMessage())
        {{$exception->getMessage()}}
    @else
        Forbidden. You don't have access.
    @endif
</h2>