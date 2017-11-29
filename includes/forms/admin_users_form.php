 <fieldset>
            <!-- Form Name -->
            <legend>Add new admin user</legend>
              <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label">User name</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  type="text" name="user_name" placeholder="user name" class="form-control" value="<?php echo $edit ? $row['user_name'] : ''; ?>"
                    </div>
                </div>
            </div>
              </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label" >Password</label> 
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="password" name="passwd" placeholder="passwaord" class="form-control" required="">
                    </div>
                </div>
            </div>
            <!-- radio checks -->
            <div class="form-group">
                <label class="col-md-4 control-label">User type</label>
                <div class="col-md-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="admin_type" value="super" required="" <?php echo ($edit &&$row['admin_type'] =='super') ? "checked": "" ; ?>/> Super admin
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="admin_type" value="admin" required="" <?php echo ($edit &&$row['admin_type'] =='admin') ? "checked": "" ; ?>/> Admin
                        </label>
                    </div>
                </div>
            </div>
            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label"></label>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
                </div>
            </div>

        </fieldset>