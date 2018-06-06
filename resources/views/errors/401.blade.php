<h2>
    @if ($exception->getMessage())
        {{$exception->getMessage()}}
    @else
        Unauthorized. You don't have access.
    @endif
</h2>