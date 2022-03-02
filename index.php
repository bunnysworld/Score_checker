<form class="container submitform" method="post">
  <div class="form-group">
        <label for="exampleInputEmail1">INPUT FORM</label>
        <input type="text" name = "geturl" class="form-control" placeholder="Enter Site url">
        <small id="emailHelp" class="form-text text-muted">Powered by RAKUUUU</small>
        <input type="submit" name="deletebtn" class="btn btn-primary submit" value="fetch url"/>
  </div>
</form>
<!-- <button class="btn btn-primary submit">Submit</button> -->
<?php
    include('simple_html_dom.php');
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    $input_url = $_POST['geturl'];
    if(!empty($input_url)){
        $html = file_get_html($input_url);
        $urls1 = array();
        foreach($html->find('a') as $element){
            if(strpos($element->href,'https://') !== false){
                array_push($urls1,$element->href);
            }else{
                if(strpos($element->href,'/') == 0){
                    array_push($urls1,$input_url.$element->href);
                }
            }
        }
        $urls1 = array_unique($urls1);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>RAKUUUU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* .hide > #data > tr {
                display: none;
            }
        .hide{
            display:none;
        } */
    </style>
</head>
<body>
<div class="container hide">
<table class="table" id="data">
  <thead>
        <tr>
        <th scope="col">No</th>
        <th scope="col">URLS</th>
        <th scope="col">CHECK SCORE</th>
        </tr>
  </thead>
  
  <tbody>
        <?php $count = 1; foreach($urls1 as $url){ if(strpos($url,'#') == false){?> 
            <tr>
                <th scope="row"><?php echo $count ?></th>
                <td>
                    <?php
                        echo $url; 
                    ?>
                </td>
                <td><a href=<?php echo 'https://pagespeed.web.dev/report?url='.$url?> target="_blank" rel="noopener noreferrer">check</a></td>
            </tr>
        <?php }$count++; }?>
  </tbody>
</table>
<nav aria-label="..." id="nav" class="container hide">
  <ul class="pagination pagination-lg"></ul>
</nav>
</div>
<script>
    $(document).ready(function(){
        var rowsShown = 14;
        var rowsTotal = $('#data tbody tr').length;
        var numPages = rowsTotal/rowsShown;
        for(i = 0;i < numPages;i++) {
            var pageNum = i + 1;
            $('#nav ul').append('<li class="page-item"><a href="#" class="page-link" href="#" rel="'+i+'">'+pageNum+'</a></li>');
        }
        $('#data tbody tr').hide();
        $('#data tbody tr').slice(0, rowsShown).show();
        $('#nav a:first').addClass('active');
        $('#nav a').bind('click', function(){
            $('#nav a').removeClass('active');
            $(this).addClass('active');
            var currPage = $(this).attr('rel');
            var startItem = currPage * rowsShown;
            var endItem = startItem + rowsShown;
            $('#data tbody tr').css('opacity','0.0').hide().slice(startItem, endItem).
            css('display','table-row').animate({opacity:1}, 300);
        });
    })
</script>
</body>
</html>