<html>
<head>
    <title>Book Author Management</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
    body
    {
      margin:0;
      padding:0;
      background-color:#f1f1f1;
    }
    .box
    {
      width:900px;
      padding:20px;
      background-color:#fff;
      border:1px solid #ccc;
      border-radius:5px;
      margin-top:10px;
    }
  </style>
</head>
<body>
  <div class="container box">
    <h3 align="center">Book Author Management</h3><br />
    <div class="table-responsive">
      <br />
      <input class="form-control" id="search_by_author_book" type="text" placeholder="Search by type author name and book name..">
      <br>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Author Name</th>
            <th>Book Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>   
    </div>
  </div>
</body>
</html>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
  
  function load_data()
  {
    $.ajax({
      url:"<?php echo base_url(); ?>bam/load_data",
      dataType:"JSON",
      success:function(data){
        var html = '<tr>';
        html += '<td id="author_name" contenteditable placeholder="Enter Author Name"></td>';
        html += '<td id="book_name" contenteditable placeholder="Enter Book Name"></td>';
        html += '<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td></tr>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<tr>';
          html += '<td class="table_data" data-row_id="'+data[count].author_id+'" data-column_name="author_name" contenteditable>'+data[count].author_name+'</td>';
          html += '<td class="table_data" data-row_id="'+data[count].book_id+'" data-column_name="book_name" contenteditable>'+data[count].book_name+'</td>';
          html += '<td><button type="button" name="delete_btn" id="'+data[count].author_id+','+data[count].book_id+'" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
        }
        $('tbody').html(html);
      }
    });
  }

  load_data();

  $(document).on('click', '#btn_add', function(){
    var author_name = $('#author_name').text();
    var book_name = $('#book_name').text();
    if(author_name == '')
    {
      alert('Enter Author Name');
      return false;
    }
    if(book_name == '')
    {
      alert('Enter Book Name');
      return false;
    }
    $.ajax({
      url:"<?php echo base_url(); ?>bam/insert",
      method:"POST",
      data:{author_name:author_name,
        book_name:book_name
      },
      success:function(data){
        load_data();
      }
    })
  });

  $(document).on('blur', '.table_data', function(){
    var id = $(this).data('row_id');
    var table_column = $(this).data('column_name');
    var value = $(this).text();
    $.ajax({
      url:"<?php echo base_url(); ?>bam/update",
      method:"POST",
      data:{id:id, table_column:table_column, value:value},
      success:function(data)
      {
        load_data();
      }
    })
  });

  $(document).on('click', '.btn_delete', function(){
    var id = $(this).attr('id');
    if(confirm("Are you sure you want to delete this?"))
    {
      $.ajax({
        url:"<?php echo base_url(); ?>bam/delete",
        method:"POST",
        data:{id:id},
        success:function(data){
          load_data();
        }
      })
    }
  });

  $("#search_by_author_book").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    console.log(value);
    $.ajax({
      url:"<?php echo base_url(); ?>bam/search",
      dataType:"JSON",
      method:"POST",
      data:{search_keyword:value},
      success:function(data){
        var html = '<tr>';
        html += '<td id="author_name" contenteditable placeholder="Enter Author Name"></td>';
        html += '<td id="book_name" contenteditable placeholder="Enter Book Name"></td>';
        html += '<td><button type="button" name="btn_add" id="btn_add" class="btn btn-xs btn-success"><span class="glyphicon glyphicon-plus"></span></button></td></tr>';
        for(var count = 0; count < data.length; count++)
        {
          html += '<tr>';
          html += '<td class="table_data" data-row_id="'+data[count].author_id+'" data-column_name="author_name" contenteditable>'+data[count].author_name+'</td>';
          html += '<td class="table_data" data-row_id="'+data[count].book_id+'" data-column_name="book_name" contenteditable>'+data[count].book_name+'</td>';
          html += '<td><button type="button" name="delete_btn" id="'+data[count].author_id+','+data[count].book_id+'" class="btn btn-xs btn-danger btn_delete"><span class="glyphicon glyphicon-remove"></span></button></td></tr>';
        }
        $('tbody').html(html);
      }
    });


  });



  
});
</script>