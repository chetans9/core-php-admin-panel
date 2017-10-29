<fieldset>
            <!-- Form Name -->
        
              <!-- Text input-->
            <div class="form-group">
                <label class="col-md-4 control-label">First Name</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input  name="f_name" placeholder="First Name" class="form-control"  type="text" required="required" value="<?php echo $edit ? $row['f_name'] : ''; ?>">
                    </div>
                </div>
            </div>

            <!-- Text input-->

            <div class="form-group">
                <label class="col-md-4 control-label" >Last Name</label> 
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input name="l_name" placeholder="Last Name" class="form-control"  type="text" required="required" value="<?php echo $edit ? $row['l_name'] : ''; ?>">
                    </div>
                </div>
            </div>
            <!-- radio checks -->
            <div class="form-group">
                <label class="col-md-4 control-label">Gender</label>
                <div class="col-md-4">
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" value="male" <?php echo ($edit &&$row['gender'] =='male') ? "checked": "" ; ?> required=""/> Male
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="gender" value="female" <?php echo ($edit && $row['gender'] =='female')? "checked": "" ; ?> required=""/> Female
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Address</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                        <input name="address" value="<?php echo $edit ? $row['address'] : ''; ?>" placeholder="Address" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Phone </label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                        <input name="phone" value="<?php echo $edit ? $row['phone'] : ''; ?>" placeholder="(845)555-1212" class="form-control" type="text">
                    </div>
                </div>
            </div>

            <!-- Text input-->
            <div class="form-group"> 
                <label class="col-md-4 control-label">State</label>
                <div class="col-md-4 selectContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <?php $opt_arr = array("Maharashtra", "Kerala", "Madhya pradesh"); 
                            ?>
                        <select name="state" class="form-control selectpicker" required>
                            <option value=" " >Please select your state</option>
                            <?php
                            foreach ($opt_arr as $opt) {
                                if ($edit && $opt == $row['state']) {
                                    $sel = "selected";
                                } else {
                                    $sel = "";
                                }
                                echo '<option value="'.$opt.'"' . $sel . '>' . $opt . '</option>';
                            }

                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="col-md-4 control-label">Email</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                        <input name="email" value="<?php echo $edit ? $row['email'] : ''; ?>" placeholder="E-Mail Address" class="form-control"  type="text">
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="col-md-4 control-label">Date of Birth</label>  
                <div class="col-md-4 inputGroupContainer">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        <input name="date_of_birth" value="<?php echo $edit ? $row['date_of_birth'] : ''; ?>"  placeholder="Birth date" class="form-control"  type="date">
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