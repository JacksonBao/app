<div class="container my-5">
    <div class="row my-5">

        <div class="col-12 col-md-4 offset-md-4 my-5">
            <div class="py-3">
                <h4 class="font-weight-light">Sign up</h4>
            </div>
            <div class="card shadow-sm rounded-lg w3-round-lg">
                <div class="card-body">
                    <form onsubmit="return false">
                        <div class="mb-3">
                            <label for="" class="w3-small">Names</label>
                            <input type="text" id="names" value="james Doe" class="form-control" placeholder="Enter fullnames">
                        </div>
                        
                        <div class="mb-3">
                            <label for="" class="w3-small">Email</label>
                            <input type="text" id="email" value="tosam@gmail.com" class="form-control" placeholder="Enter email address">
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="" class="w3-small">Password</label>
                                <input type="password" id="password" value="tosamtosam" class="form-control" placeholder="Enter pasword">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="" class="w3-small">Retype</label>
                                <input type="password" id="retype" value="tosamtosam" class="form-control" placeholder="Retype password">
                            </div>
                        </div>

                        <div class="my-2">
                            <button class="btn btn-block bg-primary text-white" onclick="signUp()">SIGN UP</button>
                        </div>
                    
                    </form>
                </div>            
            </div>
        </div>
    </div>
</div>