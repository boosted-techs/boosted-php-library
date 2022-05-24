{extends file="index.tpl"}
{block name="body"}
		<div class="banner banner-static">
			<div class="banner-bg imagebg">
				<img src="/assets/image/handshake.jpg" alt="" />
			</div>
		</div>
	
	</header>
	
	<div class="section section-contents section-contact section-pad">
		<div class="container">
			<div class="content row">

				<h2 class="heading-lg">Contact Us</h2>
				<div class="contact-content row">
					<div class="drop-message col-md-7 res-m-bttm">
						<p>We're here to help! Please contact us if you have questions or feedback about your account, or need to make any adjustments.</p>
						<form id="quote-request" class="form-quote" action="#" method="post">
								<div class="form-group row">
									<div class="form-field col-md-6 form-m-bttm">
										<input name="quote-request-name" type="text" placeholder="Name *" class="form-control required">
									</div>
									<div class="form-field col-md-6">
										<input name="quote-request-company" type="text" placeholder="Company" class="form-control">
									</div>
								</div>
								<div class="form-group row">
									<div class="form-field col-md-6 form-m-bttm">
										<input name="quote-request-email" type="email" placeholder="Email *" class="form-control required email">
									</div>
									<div class="form-field col-md-6">
										<input name="quote-request-phone" type="text" placeholder="Phone *" class="form-control required">
									</div>
								</div>
								<h4>Services You Interested</h4>
								<div class="form-group row">
									<ul class="form-field clearfix">
										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="mm"> <span> Mobile Money Collections API</span></li>
										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="sms"> <span> SMS Gateway API</span></li>
										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="utilities"> <span> Utilities API</span></li>
									</ul>
{*									<ul class="form-field clearfix">*}
{*										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="Insurance Consulting"> <span> Insurance Consulting</span></li>*}
{*										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="Taxes Consulting"> <span> Taxes Consulting</span></li>*}
{*										<li class="col-sm-4"><input type="checkbox" name="quote-request-interest[]" value="Others"> <span> Others</span></li>*}
{*									</ul>*}
								</div>
								<div class="form-group row">
									<div class="form-field col-md-6">
										<p>Best Time to Reach</p>
										<select name="quote-request-reach">
											<option value="">Please select</option>
											<option value="09am-12pm">09 AM - 12 PM</option>
											<option value="12pm-03pm">12 PM - 03 PM</option>
											<option value="03pm-06pm">03 PM - 06 PM</option>
										</select>
									</div>
									<div class="form-field col-md-6">
										<p>Hear About Us</p>
										<select name="quote-request-hear">
											<option value="">Please select</option>
											<option value="Friends">Friends</option>
											<option value="Facebook">Facebook</option>
											<option value="Google">Google</option>
											<option value="Collegue">Collegue</option>
											<option value="Others">Others</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<div class="form-field col-md-12">
										<textarea name="quote-request-message" placeholder="Messages *" class="txtarea form-control required"></textarea>
									</div>
								</div>
								<input type="text" class="hidden" name="form-anti-honeypot" value="">
								<button type="submit" class="btn">Submit</button>
								<div class="form-results"></div>
							</form>
					</div>
					<div class="contact-details col-md-4 col-md-offset-1">
						<ul class="contact-list">
							<li><em class="fa fa-map" aria-hidden="true"></em>
								<span>S.A Fridaus - Bwaise -Kampala (U), <br>P.O BOX 3904 Kampala.</span>
							</li>
							<li><em class="fa fa-phone" aria-hidden="true"></em>
								<span>Help line : +256 759 800742<br>
								Telephone :+256 759 800742</span>
							</li>
							<li><em class="fa fa-envelope" aria-hidden="true"></em>
								<span>Email : <a href="#">support[at]boosteds.co</a></span>
							</li>
							<li>
								<em class="fa fa-clock-o" aria-hidden="true"></em><span>Mon - Fri: 9AM - 6PM </span>
							</li>
							<li>
								<em class="fa fa-clock-o" aria-hidden="true"></em><span>Sat: 9AM - 3PM </span>
							</li>
							<li>
								<em class="fa fa-clock-o" aria-hidden="true"></em><span>Sun: Closed</span>
							</li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</div>
{/block}