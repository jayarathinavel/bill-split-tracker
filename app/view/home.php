<?php
if($functions -> isLoggedIn() === false){
  echo '
    <div class="container mb-3">
    <p class="text-center fw-bold"> Welcome to Bill Split Tracker Web App</p>
        <div class="col-md-12 text-center">
            <a type="button" href="/login" class="btn btn-primary">Login</a>
        </div>
    </div>';
  }
?>
<div class="alignCenter mb-3">
  <img src="/resources/memes/<?php echo rand(1,11)?>.jpg" alt="Meme" style="max-width:70%; border-radius : 5px;" /> 
</div>
<ul class="list-group mb-5">
  <a href="/weekly-bill-split" class="list-group-item" title="For a group of Friends or Roommates, where one person spends for all people in the house (Food, Snacks, Grocery, etc) and later splits the amount amoung them at Weekend. This tool can be helpful for the person who is spending, to keep track on the expenses spent Daily."> Weekly Bill Split </a>
  <a href="/dashboard" class="list-group-item" title="To Reset Password, Change Themes and More."> Dashboard </a>
</ul>