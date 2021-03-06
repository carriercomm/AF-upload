<?php

// Class to manage user information in My Profile Webpage

// Template: profile.tpl.php

class SignupCodeForm extends QForm {

	protected $txtFirstName;	
	protected $txtEmail;
	protected $txtDropDownListRegion;
	protected $txtPassword;
	protected $txtRetypePassword;
	protected $txtSignupCode;
	protected $chkAgree;
	protected $intReferral;
	protected $objReferrral;
	protected $btnCreate;

	protected function Form_Create() {

		$this->intReferral = QApplication::QueryString('referral');
		$strFirstName = QApplication::QueryString('fname');
		$strSignupCode = QApplication::QueryString('code');
		$strEmail = QApplication::QueryString('email');

		$this->txtFirstName = new QTextBox($this);
		$this->txtFirstName->CssClass = "SignupCode_input";
		$this->txtFirstName->Required = true;
		$this->txtFirstName->Text = $strFirstName;
				
		
		$this->txtEmail = new EmailTextBox($this);
		$this->txtEmail->CssClass = "SignupCode_input";
		$this->txtFirstName->Required = true;
		$this->txtEmail->Text = $strEmail;
		
		$this->txtDropDownListRegion = new QListBox($this);
		$this->txtDropDownListRegion->SelectionMode = QSelectionMode::Single;
		$this->txtDropDownListRegion->AddItem('- Select Region -', null);
		$this->txtDropDownListRegion->AddItem('East', 'East');
		$this->txtDropDownListRegion->AddItem('Central', 'Central');
		$this->txtDropDownListRegion->AddItem('West', 'West');
		$this->txtDropDownListRegion->CssClass = "SignupCode_input";
		
		$this->txtPassword = new QTextBox($this);
		$this->txtPassword->TextMode = QTextMode::Password;
		$this->txtPassword->CssClass = "SignupCode_input";
		$this->txtPassword->Required = true;

		$this->txtRetypePassword = new QTextBox($this);
		$this->txtRetypePassword->TextMode = QTextMode::Password;
		$this->txtRetypePassword->CssClass = "SignupCode_input";
		$this->txtRetypePassword->Required = true;
		
		$this->txtSignupCode = new QTextBox($this);
		$this->txtSignupCode->CssClass = "SignupCode_input";
		$this->txtSignupCode->Required = true;
		$this->txtSignupCode->Text = $strSignupCode;
		

		$this->chkAgree = new QCheckBox($this);
		$this->chkAgree->HtmlAfter = "<strong>" . QApplication::Translate('I understand and agree') . "</strong>";
		$this->chkAgree->CssClass = "Signup_check";
		$this->chkAgree->Required = true;

		$this->btnCreate = new QButton($this);
		$this->btnCreate->Text = QApplication::Translate('Create my account');
		$this->btnCreate->AddAction(new QClickEvent(), new QAjaxAction('btnCreate_Click'));
		$this->btnCreate->PrimaryButton = true;
		$this->btnCreate->CssClass = "Signup_submit";
	}
	
	public function dtgTargets_Bind(){
        $this->dtgTargets->DataSource = Target::LoadArrayByUserId($this->objUser->Id,QQ::Clause($this->dtgTargets->OrderByClause));	
	
	}

	protected function btnCreate_Click($strFormId, $strControlId, $strParameter) {

		$newUser = new User();

		if($this->txtEmail->Text == ''){
			$this->txtEmail->Text = "";
			$this->txtEmail->Warning = "You must provide an email";
			return false;

		} elseif(!$this->txtEmail->Validate())

		{
			$this->txtEmail->Text = "";
			return false;

		} else {

			$checkUser = User::LoadByUsername($this->txtEmail->Text);
			if($checkUser){
				$this->txtEmail->Warning = "This email isn't availiable";

				return false;

			}

		}
		
		if($this->txtPassword->Text != ''  and $this->txtPassword->Text != $this->txtRetypePassword->Text){
			$this->txtPassword->Warning = "Password and retype password are different";
			return false;

		}

		elseif ($this->txtPassword->Text != '') {
			$newUser->Password = sha1($this->txtPassword->Text);

		} else {
			$this->txtPassword->Warning = "You must provide a password";
			return false;

		}

		if(!($this->chkAgree->Checked)) {
			$this->chkAgree->Warning = "You neeed accept terms and contions";
			return false;

		}

		if($this->txtFirstName->Text == ''){
			$this->txtFirstName->Warning = "You must provide your full name";
			return false;

		}

		$objAccountAcme = Account::LoadByName('ACME');
		if($objAccountAcme) {
		    $newUser->AccountId = $objAccountAcme->Id;
        } else {
			$objAccountAcme = new Account();
			$objAccountAcme->Name = 'ACME';
			$AccountId = $objAccountAcme->Save();
			$newUser->AccountId = $AccountId;
		}
		
		$newUser->Username = $this->txtEmail->Text;

		$userDetail = new UserDetails();
		// TODO: Use real name
		$userDetail->LName = "Pupkin";
		$userDetail->Region = $this->txtDropDownListRegion->SelectedValue;
		$userDetailId = $userDetail->Save();
		
		$objUserCheck = User::LoadByUsername($this->txtEmail->Text);
		
		$newUser->UserDetailId = $userDetailId;

		$newUser->FullName = $this->txtFirstName->Text;
		$newUser->Username = $this->txtEmail->Text;
						
		$newUser->Active = true;
		$newUser->Save();
		
		// Try to find existing group code in DB
		$groupCode = GroupCode::LoadBySignupCode($this->txtSignupCode->Text);
		if (!$groupCode) {
		    // If not found, create new group code and save it in DB
		    $groupCode = new GroupCode();
	        $groupCode->SignupCode = $this->txtSignupCode->Text;
		    $groupCode->Save();
	    }
	    
	    // Associate user with group code
	    $newUser->AssociateGroupCode($groupCode);
		
		// Store user info in session	
		$_SESSION['User'] = serialize($newUser);

		QApplication::DisplayAlert("Your Signup was completed sucessfully");
		QApplication::Redirect(__SUBDIRECTORY__ . '/home.php');

		return true;
	}
}

?>
