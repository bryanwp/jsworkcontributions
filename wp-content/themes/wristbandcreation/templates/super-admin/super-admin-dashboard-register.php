
<?php the_title( '<h1>', '</h1>' ); ?>

<?php 
    $args = array(
        'meta_key' =>  'custom_role'
    );
    $post = $_POST;
    if ( isset( $post['form-action'] ) && $post['form-action'] === 'search-user' ) {
        $args['search'] = '*'.esc_attr( $post['admin-search'] ).'*';
    }
    $users = get_users( $args );
    
?>

    <div class="col-md-8">
        <div class="filter-user col-md-12">
          <div class="filter"> 
                <span>Bulk Action</span>
                <form method="post">
                    <select name="form-action">
                        <option value="Delete">Delete</option>
                    </select>
                    <input type="hidden" id="selected-ids" name="selected-ids" value="0">
                    <input type="hidden" name="form-action" value="bulk">
                    <input class="btn-default" type="submit" value="Apply Action">
                </form>
            </div>

            <div class="search-users">
                <form method="post">
                    <input type="text" name="admin-search">
                    <input class="btn-default" type="submit" name="search" value="Search">
                    <input type="hidden" name="form-action" value="search-user">
                </form>
            </div>
            
        </div>
        <div class="table-1 user-list col-md-12">
            <table class="admin-users" style="width: 100%">
            <thead>
                <th>Display Name</th>
                <th>Email</th>
                <th>Role</th>
            </thead>
            <?php
                foreach ( $users as $user ) {
            ?>
                <tr>
                    <td>
                        <input class="cbox" type="checkbox" name="check" value="<?php echo $user->ID; ?>">
                        <?php echo $user->display_name; ?>
                    </td>
                    <td><?php echo $user->user_email; ?></td>
                    <td><?php echo get_user_meta( $user->ID, 'custom_role', true ); ?></td>
                    <input type="hidden" id="user_id" value="<?php echo $user->ID; ?>">
                </tr>
            <?php 
                }
            ?>        
            </table>
        </div>
        
    </div>
    <div class="col-md-4">
        <div class="panel panel-login admin-reg">
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
              <form id="login-form" method="post" role="form" style="display: block;">
                <div class="form-group row">
                <h2 class="form-title">Create Account</h2>
                <hr class="divider" />
                <div class="err-container">
                    <p class="err-msg"></p>
                </div>

               
                <div class="suc-container">
                    <p class="err-msg">New <?php echo $_GET['st']; ?> was added.</p>
                </div>

                </div>
                <p class="reg-label">
                    Personal Information
                </p>
                <div class="form-group col-md-12">
                    <input type="text" name="fname" id="user-fname" tabindex="1" class="form-control" placeholder="First Name" value="">
                </div>
                <div class="form-group col-md-12">
                    <input type="text" name="lname" id="user-lname" tabindex="1" class="form-control" placeholder="Last Name" value="">
                </div>
                
                <p class="reg-label">
                    Account Information
                </p>
                <div id="admin-email" class="form-group" >
                    <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
                    <input id="check-email" type="hidden" name="check-email" value="false">
                </div>
                <div class="form-group col-md-12">
                    <input type="password" name="pass" id="user-pass" tabindex="1" class="form-control" placeholder="Password" value="">
                </div>
                <div class="form-group">
                    <select class="form-control select" name="custom_role" id="user-role">
                        <option value="" default> -- Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Employee">Employee</option>
                        <option value="Supplier">Supplier</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="hidden" name="form-action" value="add_new_aes">
                    <input type="button" id="create-user" name="add_sup_emp" value="Create User">
                </div>

              </form>
       
            </div>
          </div>
        </div>

      </div>
    </div>