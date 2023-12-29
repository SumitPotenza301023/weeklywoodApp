<div class="card">
    <div class="card-header">
        <h4>Reset Password</h4>
    </div>
    <form method="POST" id="update_password_form">
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="old_password">Old Password</label>
                    <input id="old_password" type="password" class="form-control" data-indicator="" name="old_password"
                        required>
                </div>
                <div class="form-group col-md-4">
                    <label for="password">New Password</label>
                    <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                        name="password" tabindex="2" required>
                    <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="confirm-password" type="password" class="form-control" name="confirm-password"
                        tabindex="2" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" tabindex="4">
                Reset Password
            </button>
        </div>
    </form>

</div>
