<div class="container-fluid py-4">
    <div class="row my-2">
        <div class="col-12 d-flex justify-content-center" id="todostable"> 
              
        </div>
        <div class="col-md-12">
            <?php if(!(isset($_SESSION['user']))){ ?>
                <p class="align-items-between ">To add a todo<a href="<?php echo site_url('users/login'); ?>" class="btn btn-primary mx-2">Log in</a></p>
            <?php }else{ ?>
                    <form class="form-group" id="submittodo">
                            <label class="from-control">Add a Todo</label>
                            <div id="error" class="alert alert danger" style="display:none; padding: 0 0;"></div>
                            <input type="hidden" id="todo_id" name="todo_id" value="">
                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <textarea rows="4" id="event" class="form-control" placeholder="Type your event..." name="event"></textarea>
                            <label class="from-control">Status</label>
                            <input class="from-control" type="checkbox" name="status"  value="1"><br>
                            <button class="btn btn-primary btn-sm mt-2" type="submit" id="add_todo">Add todo</button>
                            <button class="btn btn-primary btn-sm mt-2 hide" type="submit" id="update_todo">update todo</button>
                    </form>
                <?php } ?>
        </div>
  </div>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.3.1.min.js"></script>

    <script>
    $(document).ready( () => {
        function listTodos() {
                $.post("<?php echo site_url('home/get_todos');?>",
                        function (data) {
                            $('#todostable').html(data);
                        }
                        );
        }
        listTodos();

        $("#add_todo").click(function(e){  
            e.preventDefault();
            $.ajax({
                url: '<?php echo site_url('home/add_todo');?>',
                type: "POST",
                dataType: "json",
                data: $("#submittodo").serialize(),
                success: function(data){
                    if($.isEmptyObject(data.error)){
                        listTodos();
                    }else{
                        $('#error').css({display: 'block'});
                        $('#error').html(data.error);
                        $('#error p').addClass('alert alert-danger');
                    }
                }
            });  
        }); 
        $("#update_todo").click(function(e){  
            e.preventDefault();
            $.ajax({
                url: '<?php echo site_url('home/update_todo');?>',
                type: "POST",
                dataType: "json",
                data: $("#submittodo").serialize(),
                success: function(data){
                    if($.isEmptyObject(data.error)){
                        $('#update_todo').addClass('hide');
                        $('#add_todo').removeClass('hide');
                        $('#todo_id').val("");
                        $('#user_id').val("");
                        $('#event').html("");
                        $('#error').css({display: 'none'});
                        $('#error').html("");
                        listTodos();
                    }else{
                        $('#error').css({display: 'block'});
                        $('#error').html(data.error);
                        $('#error p').addClass('alert alert-danger');

                    }
                }
            });  
        }); 
        $(document).on('click', '.edit', function(){  
            var id = $(this).attr('id');
            console.log("edit button clicked");
            console.log(id);
            $.ajax({
                    url: "<?php echo site_url('home/edit_todo');?>",
                    type: "POST",
                    dataType: "json",
                    data: {'id': id
                          },
                    success: function(data){
                        $('#add_todo').addClass('hide');
                        $('#update_todo').removeClass('hide');
                        $('#todo_id').val(data.id);
                        $('#user_id').val(data.user_id);
                        $('#event').html(data.event);
                        if(data.status == 1){
                            $('input[name="status"]').attr('checked', true);
                        }else{
                            $('input[name="status"]').attr('checked', false);
                        }
                        
                    }
                });
        }); 

        $(document).on('click', '.delete', function(){  
            var id = $(this).attr('id');
            console.log("delete button clicked");
            console.log(id);
            $.ajax({
                    url: "<?php echo site_url('home/delete_todo');?>",
                    type: "POST",
                    dataType: "json",
                    data: {'id': id
                          },
                    success: function(data){
                        console.log(data);
                        listTodos();
                    }
                });
        }); 
        
        $(document).on('keyup', '#search', function(){  
            var keyword = $("#search").val();
            console.log("searching...");
            console.log(keyword);
            $.post("<?php echo site_url('home/search_todos');?>", {keyword: keyword},
                        function (data) {
                            $('#todostable').html(data);
                        }
                        );
        });

    });
</script>
</body>
</html>
    