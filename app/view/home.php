<?php
if($functions -> isLoggedIn() === false){
  echo '
    <div class="container bg-light">
        <div class="col-md-12 text-center">
            <a type="button" href="/login" class="btn btn-primary">Login</a>
        </div>
    </div>';
  }
?>
<div class="alignCenter mb-3">
  <img src="/resources/memes/<?php echo rand(1,11)?>.jpg" alt="Meme" style="max-width:70%; border-radius : 5px;" /> 
</div>
<ul class="list-group">
  <li class="list-group-item"><a href="/weekly-bill-split" class="text-decoration-none"> Weekly Bill Split </a></li>
  <li class="list-group-item"><a href="/dashboard" class="text-decoration-none"> Dashboard </a></li>
</ul>