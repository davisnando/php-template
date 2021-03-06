
  <link rel="stylesheet" href="<?php LoadStatic(); echo GetStaticFile('board','board.css')?>">

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h1>Dashboard</h1>          
          <h2>Change User</h2>
                <?php
                  $db = new model();
                  $db->prepare("SELECT Users.id,Users.email,Users.username, Personal.* FROM Users JOIN Personal on Users.Personal=Personal.id WHERE Users.username=:user");
                  $items = explode('/',$_GET['path']);
                  $user = $items[count($items) - 1];
                  $db->bind(":user",$user);
                  $result = $db->GetAll();
                  $i = 1;
                ?>
            <form method="POST" id="Changes">
                <br>
                <?php
                  $i = 0; 
                  $allKeys = array_keys($result[0]);
                  if(count($result) != 1){
                    header("location: ../dashboard");
                  }
                ?>
                <?php foreach($result[0] as $item): ?>
                   <?php 
                     $itemkey  = $allKeys[$i];
                     $i++;
                   ?>
                   <?php if($itemkey != "id" && $itemkey != "Personal" && $itemkey != "username"): ?>
                     <input type="" class="form-control" name="<?php echo $itemkey ?>" value="<?php echo $item; ?>">
                     <br>
                   <?php endif;?>
                   <?php if($itemkey == "id"):?>
                     <?php $_SESSION['ChangeID'] = $item;?>
                   <?php endif;?>
                <?php endforeach;?>
              <input type="submit" class="btn btn-success" value="save">
            </form>
          </div>
        </main>
      </div>
    </div>
    <script>
    $("#Changes").submit(function(){
        var GetData = $('#Changes').serialize();
        $.ajax({
          method: "POST",
          url: "/admin/change",
          data: GetData
        })
          .done(function( msg ) {
            // console.log(msg);
              if(msg == "Done"){
                alert("Saved");
              }else{
                alert("something went wrong!");
              }
          });
        return false;
      });
    </script>