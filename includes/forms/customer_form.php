<fieldset>
    <div class="form-group">
        <label for="f_name">First Name *</label>
          <input type="text" name="f_name" value="<?php echo $edit ? $row['f_name'] : ''; ?>" placeholder="First Name" class="form-control" required="required" id = "f_name" >
    </div> 

    <div class="form-group">
        <label for="l_name">Last name *</label>
        <input type="text" name="l_name" value="<?php echo $edit ? $row['l_name'] : ''; ?>" placeholder="Last Name" class="form-control" required="required" id="l_name">
    </div> 

    <div class="form-group">
        <label>Gender * </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="male" <?php echo ($edit &&$row['gender'] =='male') ? "checked": "" ; ?> required="required"/> Male
        </label>
        <label class="radio-inline">
            <input type="radio" name="gender" value="female" <?php echo ($edit && $row['gender'] =='female')? "checked": "" ; ?> required="required" id="female"/> Female
        </label>
    </div>

    <div class="form-group">
        <label>Adress</label>
          <input name="address" value="<?php echo $edit ? $row['address'] : ''; ?>" placeholder="Address" class="form-control" type="text">
    </div> 

    <div class="form-group">
        <label>State </label>
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
    <div class="form-group">
        <label>Email</label>
            <input  type="email" name="email" value="<?php echo $edit ? $row['email'] : ''; ?>" placeholder="E-Mail Address" class="form-control">
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
            <input name="phone" value="<?php echo $edit ? $row['phone'] : ''; ?>" placeholder="987654321" class="form-control"  type="text" id="phone">
    </div> 

    <div class="form-group">
        <label>Date of birth</label>
        <input name="date_of_birth" value="<?php echo $edit ? $row['date_of_birth'] : ''; ?>"  placeholder="Birth date" class="form-control"  type="date">
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>            
</fieldset>