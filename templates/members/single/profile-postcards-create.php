<?php do_action( 'pp_pc_before_create_postcards_page' ); ?>

<?php 
$from_user_id = bp_loggedin_user_id();
$from_name = bp_core_get_user_displayname( $from_user_id );
$from_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $from_user_id ) );	

$to_user_id = $_GET['r']; 
$to_name = bp_core_get_user_displayname( $to_user_id ); 
$to_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $to_user_id ) );	

$action = bp_loggedin_user_domain() . 'postcards/create/?r=' . $to_user_id . '&amp;pc_nonce=' . $_GET['pc_nonce']; 
?>
	
<div id="buddypress">

	<?php do_action( 'pp_pc_before_create_postcards_template' ); ?>
	
	<h4><?php echo sprintf( __( 'Send a Post Card to %s', 'postcards' ), $to_name ); ?></h4>
	
	<?php do_action( 'pp_pc_before_create_postcard' ); ?>
	
	<?php do_action( 'template_notices' ); ?>
	
	<form id="postcard-form" action="<?php echo $action; ?>" method="POST" class="standard-form">
	
		<fieldset>
			<legend>Choose Image</legend>
			<input type="radio" name="pc_img" value="1"> Image One<br>
			<input type="radio" name="pc_img" value="2"> Image Two<br>
			<input type="radio" name="pc_img" value="3"> Image Three
		</fieldset>
		
		<fieldset>
			<legend>Write Message</legend>
			<label for="pc_message">Message <em>(max 350 characters per LOB)</em></label>
			<textarea id="pc_message" name="pc_message"></textarea>
			<div id="charNum"></div>
		</fieldset>
		
		<fieldset>
			<legend>Addresses</legend>
			<h4>From Details:</h4>
			<p>
			
			<label for="pc_from_name">Name</label>
				<input id="pc_from_name" name="pc_from_name" type="text" value="<?php echo $from_name; ?>" />
			
			<label for="pc_from_address">Address</label>		
				<input id="pc_from_address" name="pc_from_address" type="text" value="<?php echo $from_user['pl-address']; ?>" placeholder="Please enter your address" />	
				
			<label for="pc_from_city">City</label>				
				<input id="pc_from_city" name="pc_from_city" type="text" name="pc_from_city" value="<?php echo $from_user['pl-city']; ?>" />

			<label for="pc_from_state">State</label>	
				<input id="pc_from_state" name="pc_from_state" type="text" name="pc_from_state" value="<?php echo $from_user['pl-state']; ?>" />
				
			<label for="pc_from_zip">Postal Code</label>				
				<input id="pc_from_zip" name="pc_from_zip" type="text" name="pc_from_zip" value="<?php echo $from_user['pl-zip']; ?>" />

			<label for="pc_from_country">Country</label>				
				<input id="pc_from_country" name="pc_from_country" type="text" name="pc_from_country" value="<?php echo $from_user['pl-country']; ?>" />
			
			</p>
			
			<p>&nbsp;</p>
			
			<p>
			<h4>To Details:</h4>

			<label for="pc_to_name">Name</label>
				<input id="pc_to_name" name="pc_to_name" type="text" value="<?php echo $to_name; ?>" />
			
			<label for="pc_to_address">Address</label>		
				<input id="pc_to_address" name="pc_to_address" type="text" value="<?php echo $to_user['pl-address']; ?>" placeholder="Please enter your address" />	
				
			<label for="pc_to_city">City</label>				
				<input id="pc_to_city" name="pc_to_city" type="text" name="pc_to_city" value="<?php echo $to_user['pl-city']; ?>" />

			<label for="pc_to_state">State</label>	
				<input id="pc_to_state" name="pc_to_state" type="text" name="pc_to_state" value="<?php echo $to_user['pl-state']; ?>" />
				
			<label for="pc_to_zip">Postal Code</label>				
				<input id="pc_to_zip" name="pc_to_zip" type="text" name="pc_to_zip" value="<?php echo $to_user['pl-zip']; ?>" />

			<label for="pc_to_country">Country</label>				
				<input id="pc_to_country" name="pc_to_country" type="text" name="pc_to_country" value="<?php echo $to_user['pl-country']; ?>" />
			</p>	
		
		</fieldset>
		
		
		<fieldset>
			<legend>Send</legend>
			<p>
				<input id="submit_postcard" type="submit" value="Send Postcard">
			</p>
		</fieldset>
		
		<fieldset>
			<legend>Confirmation</legend>
			for now, show the array returned by LOB - or error message
		</fieldset>
	
		<input type="hidden" name="pc_creator" value="2">
	</form>
	
	<?php do_action( 'pp_pc_after_create_postcard' ); ?>
	
	<?php 
	if( isset( $_POST['pc_creator'] ) && $_POST['pc_creator'] == '2' )
		$submit_step = '5';
	else
		$submit_step = '';
	?>
	
    <script>
        $( function() {
            var $signupForm = $( '#postcard-form' );
            var submitStep = '<?php echo $submit_step; ?>';
            
           // $signupForm.validationEngine();
            
            $signupForm.pcFormWizard({
                submitButton: 'submit_postcard',
                showProgress: true, //default value for showProgress is also true
                nextBtnName: 'Next >',
                prevBtnName: '< Back',
                showStepNo: true,
                
               // validateBeforeNext: function() {
                //    return $pcFormWizard.validationEngine( 'validate' );
               // }
            });
            
            
            if( submitStep == '5' ) {
               $signupForm.pcFormWizard( 'GotoStep', '5' );
 		    }
            
            $( '#btn_next' ).click( function() {
                $signupForm.pcFormWizard( 'NextStep' );
            });
            
            $( '#btn_prev' ).click( function() {
                $signupForm.pcFormWizard( 'PreviousStep' );
            });
        });
    </script>	
	
	<?php do_action( 'pp_pc_after_create_postcard_content_template' ); ?>

</div>

<?php do_action( 'pp_pc_after_create_postcard_page' ); ?>