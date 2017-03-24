 
 
<div class="container">
    <div class="col-sm-4"></div>
    
    <div class="col-sm-4">
        <div class="gap-150"></div>
       <?php echo validation_errors(); ?> 
       <?php echo form_open('VerifyLogin'); ?>
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="username" class="sr-only">Username</label>
        <input type="text"  class="form-control" id="username" name="username" placeholder="UserName" required />
         <br>
        <label for="inputPassword" class="sr-only">Password</label>
         <input type="password" id="passowrd" class="form-control" name="password" placeholder="Password"/>
         <br>
         <button class="btn btn-sm btn-primary pull-right" type="submit"">Sign in</button>
         <button class="btn btn-sm btn-warning pull-right" type="reset">Clear</button>
      </form>
    </div>
    <div class="col-sm-4"></div>
    </div> <!-- /container -->
    
  
 
  