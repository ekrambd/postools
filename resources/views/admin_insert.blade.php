<form action="{{URL::to('/insert-user')}}" method="post">
@csrf
 <input type="text" name="name">
 <input type="email" name="email">
 <input type="password" name="password">	
 <button type="submit">Sumit</button>
</form>