
<!DOCTYPE html>
<html lang="en">
<head>
<title>YoGames</title>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
<link rel="stylesheet" href="css/matrix-style.css" />
<link rel="stylesheet" href="css/matrix-media.css" />
<link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" href="css/UploadGamesPage.css"/>
</head>
<body>
<?php
include"dash-menu.php"
?>

<!--main-container-part-->
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.php" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    </div>
    <!--form of input -->
   <form>
       <div  id="input" class="upload-game-div container" >
           <h1   style= "color: white font-weight: bold ;margin-right: 35px ; margin-bottom: 20px" >Upload Games </h1>
           <!--        <form  action="UploadGamesPage.php" method="POST" enctype="multipart/form-data">-->
           <input    class="input-game" type="text" id="gname" name="gname" placeholder="Game Name">
           <br>
           <textarea class="input-game" id=tags placeholder="Tags"></textarea>
           <br>
           <input class="input-game" type="text" id="classification"  placeholder="Classification">
           <br>
           <form>
               <p style=" margin-left: 30px"> Upload image <input id="image"  type="file" name="file"></p>
           </form>
           <br>
           <button  id="test"  style=" background-color: darkorange" type="button" class=" buttons btn-primary">Test</button>
           <button  type="button" onclick="reset()" class="buttons   btn-primary">Reset</button>
       </div>
           <!--</form>-->

       <!-- card view-->
           <div class="">



   </form>
    <div id="img" class=" card-body img-test but-test cardImg card-img">


        <b class="game-description" hidden><?php echo $row['description']?></b>
    </div>

    </div>
    </div>
</div>




    <!--Turning-series-chart-js-->
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery.ui.custom.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<script src="js/jquery.peity.min.js"></script>
<script src="js/fullcalendar.min.js"></script>
<script src="js/matrix.js"></script>
<script src="js/matrix.dashboard.js"></script>
<script src="js/jquery.gritter.min.js"></script>
<script src="js/matrix.interface.js"></script>
<script src="js/matrix.chat.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/matrix.form_validation.js"></script>
<script src="js/jquery.wizard.js"></script>
<script src="js/jquery.uniform.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/matrix.popover.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/matrix.tables.js"></script>
<script src="js/matrix.dashboard.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    <script>

       function  reset() {
           // document.getElementById("input").reset();
           $("#gname").val("");
           $("#game-tags").val("");
           $("#classification").val("");
           $("#image").val("");
          
       }

              $(document).ready(function () {

                  //-------------------AutoComplete-----------------//
                  $("#gname").keyup(function () {
                      var gameName = $("#gname").val();
                      if (gameName !== ""){
                          $.ajax({
                              url: "operations/serch_game.php",
                              data: {gameName:gameName},
                              method:"POST",
                              success: function (data) {
                                  if (data === "found" ){
                                      $("#gname").removeClass("inputValid");
                                      $("#gname").addClass("inputError");
                                      $("#test").attr("disabled", true)
                                          .css("cursor","not-allowed");
                                  } else if (data === "not found") {
                                      $("#gname").removeClass("inputError");
                                      $("#gname").addClass("inputValid");
                                      $("#edit").css("visibility", "visible");
                                      $("#test").attr("disabled",false)
                                          .css("cursor","pointer");
                                  }
                              }
                          });
                      }
                });

                  //------------------------ ADD NEW GAME ---------------------------//

                  $("#upload-submit").click(function () {
                      var game_name = $("#gname").val();
                      var game_tags = $("#tags").val();
                      var classification = $("#classification").val();
                      $.ajax({
                          url: "operations/upload_game.php",
                          data: {game_name: game_name, game_tags: game_tags, classification: classification},
                          type: "POST",
                          success: function (data) {
                              if (data === "done") {
                                  alert("game uploaded");
                              } else {
                                  alert("upload error");
                              }

                          }
                      });
                  });


                  //  ------------  ADD TO TEST TABLE ----------- //
                  $("#test").click(function () {
                      var game_name = $("#gname").val();
                      var game_tags = $("#tags").val();
                      var classification = $("#classification").val();
                      var upload_type = "FOR TEST";

                          $.ajax({
                              url: "operations/upload_game.php",
                              data: {

                                  game_name: game_name,
                                  game_tags: game_tags,
                                  classification: classification,
                                  upload_type: upload_type

                              },
                              type: "POST",
                              success: function (data) {





                                  }


                          });









                  //------------------ UPLOAD PROFILE IMAGE ------------------//


                      var imageProperty = document.getElementById("image").files[0];
                      var imageName = imageProperty.name;
                      var imageExtension = imageName.split('.').pop().toLowerCase();
                      var allowedExt = ['png', 'jpg', 'jpeg'];
                      var imageSize = imageProperty.size;
                      if(jQuery.inArray(imageExtension, allowedExt) === -1){
                          swal({
                              title: "صيغة الصورة ليست صحيحة",
                              icon: "error",
                              button: "موافق"
                          });
                      }else if(imageSize > 2000000){
                          swal({
                              title: "2MB حجم الصورة أكبر من ",
                              icon: "error",
                              button: "موافق"
                          });
                      }else {
                          var formData = new FormData();
                          formData.append("image", imageProperty);
                          $.ajax({
                              url: "operations/game_image_upload.php",
                              data: formData,
                              method: "POST",
                              contentType: false,
                              processData: false,
                              cache: false,
                              success:function(data) {
                                  $("#img").html(data);
                                  $("#test").attr("disabled", true)
                                      .css("cursor","not-allowed");
                              }
                          });
                      }








                  });
              });







          </script>
</body>
</html>
