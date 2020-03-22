<form method="POST" action="{{$route}}">
    @csrf
    @method('DELETE')
    <button type="submit">Dzēst</button>
</form>