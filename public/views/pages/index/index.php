<div class="container-fluid bg-dark py-5" id="about" style="background: url(/public/img/app/background-1.jpg)no-repeat ; background-size:cover;background-blend-mode:soft-light">
	<div class="container py-5 my-5">

		<div class="text-center">
			<h4 class="font-weight-light" style="letter-spacing: 3px;"> WELCOME TO </h4>
			<div class="display-3 mb-3"><b style="letter-spacing: 7px;"> THANOSAPI</b> <sup class="badge badge-md badge-danger _text_12">v1.0</sup> </div>
			<div class="col-12 col-md-6 offset-md-3">
				<p class="lead">Developing APIs(stones) for developers by developers. We aim at building api which are fast, reliable and easily customizable. Our api's are simple to use and provided by Njofa for all its citizens. </p>

			</div>
		</div>

	</div>
</div>

<div class="container-fluid py-5 bg-white">
	<div class="container py-5 my-5">
		<div class="row">
			<div class="col-12 mb-4 text-center">
				<h4>WHAT YOU NEED</h4>
			</div>
			<div class="col-12 col-md-10 offset-md-1">
				<div class="d-flex flex-wrap py-4">
					<div class="col-6 col-md-4 mb-3 text-center">
						<div class="mb-3 display-3">
							<i class="fa fa-user"></i>
						</div>
						<div class="lead mb-3">
							Create Account
						</div>
						<small>Use your njofa account/ create account to generate your api key.</small>
					</div>
					<div class="col-6 col-md-4 mb-3 text-center">
						<div class="mb-3 display-3">
							<i class="fa fa-key"></i>
						</div>
						<div class="lead mb-3">
							Get Key
						</div>
						<small>Generate your thanos api key from dashboard. To use with all apis.</small>
					</div>
					<div class="col-6 col-md-4 text-center">
						<div class="mb-3 display-3">
							<i class="fas fa-exchange-alt"></i>
						</div>
						<div class="lead mb-3">
							Make Call
						</div>
						<small>Make calls to any thanos api endpoint with your generated key.</small>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>



<div class="container-fluid py-5" id="contact-us">
	<div class="container py-5 my-5">
		<div class="row">
			<div class="col-12 col-md-12  ">
				<div class="row">
					<div class="col-12 col-md-4 offset-md-1 align-self-center mb-3">
						<div class="text-center">
							<h2 class="">Message Us</h2>
							<p class="lead">
							What would you like to get in contact with us? or Request an API to be built? or Join our team? Leave us a message and we will get back to you within 2 business days.
							</p>
						</div>
					</div>
					<div class="col-12 col-md-7 p-0 p-md-3">
						<div class="col-12 col-md-9 py-3 offset-md-2 rounded pt-5 shadow-sm bg-light">

							<form class="" onsubmit="return false" id="_messageForm">
								<div class="d-flex flex-wrap">
									<div class="col-12 col-md-6 mb-3">
										<input type="text" placeholder="Full names" class="form-control fo" id="_userNames">
									</div>

									<div class="col-12 col-md-6 mb-3">
										<input type="text" placeholder="Email address" class="form-control fo" id="_email">
									</div>
								</div>

								<div class="col-12 col-md-12 mb-3">
									<input type="text" placeholder="Enter subject" class="form-control fo" id="_subject">
								</div>


								<div class="col-12 col-md-12 mb-3">
									<textarea name="" class="form-control fo" placeholder="Enter message" id="_message" cols="30" rows="10"></textarea>
								</div>
								<div class="mb-3 col-12">
									<button class="btn btn-third btn-block" id="submitMessage">SUBMIT MESSAGE</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="container-fluid py-5 bg-third" id="stones">
	<div class="container py-5 my-5">
		<div class="row">
			<div class="col-12 mb-3">
				<div class="display-3" style="letter-spacing: 10px;">Our <b>STONES</b> Directory</div>
				<p>List of available api stones in our gallaxy</p>
			</div>
			<div class="col-6 col-md-4 col-lg-3 text-dark">
				<div class="card shadow text-center">
					<div class="card-body">
						<div class="mb-2 text-center py-3 display-3">
							<i class="fa fa-money-bill text-third"></i>
						</div>
						<div class="py-3">
							<h5 class="font-weight-light">Currency Stone</h5>
						</div>
						<div class="py-2 mb-3">
							<a href="/currency" class="btn text-white btn-block btn-third">DOCUMENTATION</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<div class="container-fluid py-5" id="login">
	<div class="container py-5 my-5">
		<div class="row">
			<div class="col-12 col-md-12  ">
				<div class="row">
					<div class="col-12 col-md-4 order-1 order-md-2 offset-md-1 align-self-center mb-3">
						<div class="text-center">
							<h2 class="">Login to Dashboard</h2>
							<p class="lead">
							Already have an account on Njofa? Login to view and manage your API request in thanosapi dashboard.
							</p>
						</div>
					</div>
					<div class="col-12 col-md-7 order-2 order-md-1 p-0 p-md-3">
						<div class="col-12 col-md-8 py-3 offset-md-2 rounded pt-5 ">
							<!-- phase one  -->
							<div class="bg-white shadow w3-round-large p-3 py-4 mb-3" id="_phase_1">
								<p class="mb-4 w3-text-grey"> Login to your njofa account</p>
								<div class="mb-3">
									<label class="w-100" for="">
										<div class="float-right w3-text-theme w3-opacity w3-right" title="Enter your njofan phone or email " data-toggle="tooltip"> <i class="fa fa-question-circle"></i></div>
										Phone/Email
									</label>
									<input type="text" placeholder="Phone or email" class="form-control" id="_wallet_contact">
									<span id="_wallet_contactStatus"></span>
								</div>

								<div class="mb-3">
									<label for="" class="w-100">
										<div class="float-right w3-text-theme w3-opacity w3-right" title="Enter your njofa account password. " data-toggle="tooltip"> <i class="fa fa-question-circle"></i></div>
										Password
									</label>
									<div class="input-group">
										<input type="password" placeholder="password" class="form-control" id="_wallet_password">
										<div class="input-group-append bg-white" onclick="togglePassword('_wallet_password')">
											<span class="input-group-text bg-white" id="basic-addon1"><i class="fa fa-eye"></i></span>
										</div>

										<span id="_wallet_passwordStatus"></span>
									</div>
								</div>

								<button class="btn btn-block btn-third w3-theme mb-4" id="_oauthBtn" onclick="oauthWalletCitizen('user')">NEXT</button>
							</div>
							<!-- phase one -->

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>







<div class="container-fluid py-5 bg-primary" id="signup" style="background: url(public/img/app/world_background.jpg)no-repeat;background-size:cover;background-blend-mode:overlay">
	<div class="container py-5 my-5">
		<div class="row">
			<div class="col-12 col-md-12  ">
				<div class="row">
					<div class="col-12 col-md-4 offset-md-1 align-self-center mb-3">
						<div class="text-center text-white">
							<h2 class="">Becoming a citizen</h2>
        <p class="lead">
		Join our community of awesome people. With one account you can travel across all njofa applications.</p>
						</div>
					</div>
					<div class="col-12 col-md-7 p-0 p-md-3">
						<div class="col-12 col-md-9 py-3 offset-md-2 rounded pt-5 ">
						<form onsubmit="return false">
                    <!-- phase one  -->
                    <div class="bg-white shadow w3-round-large p-3 py-4 pt-5 mb-3" id="_phase_1">
                        <div class="d-flex flex-wrap mb-3">
                            <div class="col-12 col-sm-6 mb-3">
                                <label for="_firstname">Firstname</label>
                                <input type="text" placeholder="Firstname" name="_firstname" id="_firstname" class="form-control">
                                <span id="_firstnameStatus"></span>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label for="_lastname">Other names</label>
                                <input type="text" placeholder="Other names" name="_lastname" id="_lastname" class="form-control">
                                <small id="_lastnameStatus">Separate each name with a space.</small>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap mb-3">

                        <div class="mb-3 col-8">
                        <label class="w-100" for="">
                            <div class="float-right w3-text-theme w3-opacity w3-right" title="Enter your email." data-toggle="tooltip"> <i class="fa fa-question-circle"></i></div> 
                                Email address 
                            </label>
                            <input type="email" placeholder="Email" class="form-control" id="_email">
                            <span id="_emailStatus"></span>
                        </div>
                        <div class="mb-3 col-4">
                            <label for="">Gender</label>
                        <select class="custom-select" id="_gender">
                            <option value="">Gender</option>
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                        <span id="_genderStatus"></span>
                        </div>
                        </div>

                        <div class="d-flex flex-wrap mb-3">
                            <div class="col-4">
                                <label for="">Day</label>
                                <select class="custom-select" name="_day" id="_day">
                                    <option value="">Select day</option>
                                    <?php
                                        for ($i=1; $i < 32 ; $i++) { 
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }
                                    ?>
                                </select>
                                <span id="_dayStatus"></span>
                            </div>
                            <div class="col-4">
                                <label for="">Month</label>
                                <select class="custom-select" name="_month" id="_month">
                                    <option value="">Select month</option>
                                    <?php 
                                    for ($i = 0; $i < 12;   $i++) {
                                        $date_str = date('M', strtotime("+ $i months"));
                                        echo '<option value="' .$date_str . '"> ' .$date_str . '</option>';
                                        } 
                                    ?>
                                </select>
                                <span id="_monthStatus"></span>
                            </div>
                            <div class="col-4">
                                <label for="">Year</label>
                                <input type="text" placeholder="Year" name="_year" id="_year" class="form-control">
                                <span id="_yearStatus"></span>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap mb-3">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="_password">Password</label>
                            <div class="input-group">
                                <input type="password" placeholder="*******" name="_password" id="_password" class="form-control">
                                <div class="input-group-append bg-white" onclick="togglePassword('_password')">
                                <span class="input-group-text bg-white" id="basic-addon1"><i class="fa fa-eye"></i></span>
                            </div>
                            </div>
                                <span id="_passwordStatus"></span>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="_retype">Retype password</label>
                            <div class="input-group">
                                <input type="password" placeholder="*******" name="_retype" id="_retype" class="form-control">
                                <div class="input-group-append bg-white" onclick="togglePassword('_retype')">
                                    <span class="input-group-text bg-white" id="basic-addon1"><i class="fa fa-eye"></i></span>
                                </div>
                            </div>
                                <span id="_retypeStatus"></span>
                            </div>
                        </div>

						<div class="text-center mb-3 w3-small">
						By click Sign Up you agree to Our Terms of Use, and that you have read our Privacy Policies.
</div>

                        <div class="col-12">
                        <button class="btn btn-block btn-third w3-theme mb-4" id="_oauthBtn" onclick="oauthCitizenApplication()">SIGN UP</button>
                        </div>
                    </div>
                    <!-- phase one -->

                

            </form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>