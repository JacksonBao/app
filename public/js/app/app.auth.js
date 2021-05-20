var redirectUrl = '';
new UserLocation();


function oauthWalletCitizen(type) {
    var form = new ValidateForm();
    form.inputs = [...[
        // { name: 'type', value: type, null: false, id: '', meth: 'string', strict: true, min: 3, max: 45, message: 'Invalid authentication type' },
        { name: 'contact', value: $('#_wallet_contact').val(), id: '_wallet_contact', meth: 'string', strict: true, min: 7, max: 255, message: 'Enter a valid contact.' },
        { name: 'password', value: $('#_wallet_password').val(), id: '_wallet_password', meth: 'string', strict: false, min: 8, max: 0, message: 'Enter a valid password.' },
    ]];

    var result = form.sanitizeForm();
    if (form.hasError == false) {
        // get location
        var location = new UserLocation();
        result.latitude = location.latitude || '0.00';
        result.longitude = location.longitude || '0.00';

        _('_oauthBtn').disabled = true;
        $.post(
            '/auth/oauth-citizen',
            result,
            (res) => {
                console.log(res);
                _('_oauthBtn').disabled = false;

                var results = manageResponse(res);
                if (results.status == true) {
                    // redirect to the correct site
                    snackBar('Login successfull');
                    setTimeout(() => {
                        window.location.assign('/dashboard');
                    }, 2000);
                } 
            }).fail((e) => {
                console.log(e);
            });
    } else {
        formErr(form.errorId, form.errorMessages);
    }

}

var walletReferer = '';
function oauthCitizenApplication() {
    var form = new ValidateForm();
    form.inputs = [...[
        { name: 'firstname', value: $('#_firstname').val(), null: false, id: '_firstname', meth: 'string', strict: true, min: 3, max: 45, message: 'Firstname must be at least 3 characters' },
        { name: 'lastname', value: $('#_lastname').val(), null: false, id: '_lastname', meth: 'string', strict: true, min: 3, max: 45, message: 'Lastname must be at least 3 characters' },
        { name: 'email', value: $('#_email').val(), null: false, id: '_email', meth: 'string', strict: true, min: 5, max: 45, message: 'Enter a valid email address' },
        { name: 'gender', value: $('#_gender').val(), null: false, id: '_gender', meth: 'string', strict: true, min: 4, max: 45, message: 'Enter a valid gender.' },
        { name: 'day', value: $('#_day').val(), null: false, id: '_day', meth: 'int', strict: true, min: 1, max: 45, message: 'Invalid day.' },
        { name: 'month', value: $('#_month').val(), null: false, id: '_month', meth: 'string', strict: true, min: 3, max: 45, message: 'Invalid month of birth' },
        { name: 'year', value: $('#_year').val(), null: false, id: '_year', meth: 'int', strict: true, min: 4, max: 45, message: 'Invalid year of birth' },
        { name: 'password', value: $('#_password').val(), null: false, id: '_password', meth: 'string', strict: true, min: 8, max: 255, message: 'Enter a valid password atleast 8 characters.' },
        { name: 'password2', value: $('#_retype').val(), null: false, id: '_retype', meth: 'string', strict: true, min: 8, max: 0, message: 'Password do not match.' },
        { name: 'njrrid', value: walletReferer, null: true, id: '', meth: 'string', strict: true, min: 8, max: 0, message: 'Password do not match.' },
        { name: 'location', null: true, value: Cookie.getCookie('user_location'), id: '', meth: '', strict: false, min: 5, max: 255, message: 'Invalid email address.' },
    ]];

    var result = form.sanitizeForm();
    if (form.hasError == false) {
        
        _('_oauthBtn').disabled = true;
        $.post(
            '/auth/oauth-citizen-application',
            result,
            (res) => {
                console.log(res);
                _('_oauthBtn').disabled = false;
                var response = manageResponse(res);
                if (response.status == true) {
                    window.location.assign('/auth/create');
                }
            }).fail(function  (e){
                console.log(e);
            });
    } else {
        formErr(form.errorId, form.errorMessages);
    }
}
