<?php
/*
Group 13
December 1, 2016
WEBD3201
The Acceptable Use Policy page
*/
$title = "Acceptable Use Policy";
$date = "December 1, 2016";
$filename = "aup.php";
$description = "'Acceptable Use policy for users to read";
include("header.php");
?>

<section class="content-body policy" id='result'>
        <div class="max-width body-place">			
            <h2 class="title">Acceptable Use Policy</h2>
            <h2>Overview</h2>
			<p>The purpose of this policy is to establish acceptable and unnacceptable use of <?php echo WEBSITE_NAME; ?> in conjuction with its established trust and behaviour.</p>
			<p><?php echo WEBSITE_NAME; ?> provides informational systems to manage listings to be viewed to users that are interested and must be managed responsibly to maintain confidentiality and verified to users. This policy requires the users on <?php echo WEBSITE_NAME; ?> to conform to the appropriate uses of this site to protect against legal issues.<br/>
			</p>
			
			<h2> Scope </h2>
			<p>
				All clients, agents, admins, and any other personnel affiliated with <?php echo WEBSITE_NAME; ?> must adhere to this policy. <br/>
			</p>
			
			<h2> Policy Statement </h2>
			<p>	
				You are responsible for exercising a conventional use <?php echo WEBSITE_NAME; ?> resources in accordance with <?php echo WEBSITE_NAME; ?> policies, standards, and guidelines. <?php echo WEBSITE_NAME; ?> resources and other provided information may not be used for any unlawful or prohibited purposes.
				<br/> 
			</p>
				<p>
				Users of <?php echo WEBSITE_NAME; ?> that interfere with other users on <?php echo WEBSITE_NAME; ?> may be disconnected from <?php echo WEBSITE_NAME; ?>.
				</p>
				<br/>
			<h2> System Accounts </h2>
			<p>
				You are responsible for the security of data, accounts, and systems under your control. Keep passwords secure and do not share account or password information with anyone including other personnel or friends. You must maintain system-level and user-level passwords in accordance with the Password Policy.
			</p>
			<p>
				You must ensure through legal or technical means that proprietary information remains within the control of <?php echo WEBSITE_NAME; ?> at all times. 
			</p>
			<h2> Computing Assets </h2>
			<p>
				All PCs, PDAs, laptops, and workstations must be secured with a password-protected screensaver with the automatic activation feature set to 10 minutes or less. You must lock the screen or log off when the device is unattended.
			</p>
			<h2> Network Use </h2>
			
			<p>	You are responsible for the security and appropriate use of <?php echo WEBSITE_NAME; ?> network resources under your control. Using <?php echo WEBSITE_NAME; ?> resources for the following is strictly prohibited:
			</p>
			<ul>
				<li>Causing a security breach to either <?php echo WEBSITE_NAME; ?> or other network resources, including, but not limited to, accessing data, servers, or accounts to which you are not authorized; circumventing user authentication on any device; or sniffing network traffic.</li>
				
				<li>Causing a disruption of service to either <?php echo WEBSITE_NAME; ?> or other network resources, including, but not limited to, ICMP floods, packet spoofing, denial of service, heap or buffer overflows, and forged routing information for malicious purposes.</li>
				
				<li>Violating copyright law, including, but not limited to, illegally duplicating or transmitting copyrighted pictures.</li> 
				
				<li>Intentionally introducing malicious code, including, but not limited to, viruses, worms, Trojan horses, e-mail bombs, spyware, adware, and keyloggers.</li> 
			</ul>
			
			<h2> Electronic Communications </h2>
			<p>
			The following are strictly prohibited:
			</p>
			<ul>
				<li>Sending Spam via e-mail, text messages, pages, instant messages, voice mail, or other forms of electronic communication.</li>
				
				<li>Forging, misrepresenting, obscuring, suppressing, or replacing a user identity on any electronic communication to mislead the recipient about the sender.</li>
				
				<li>Posting duplicates of a listing to <?php echo WEBSITE_NAME; ?>.</li>
			</ul>
			
			<h2> Enforcement </h2>
			<p>
			An agent, client, or admin found to have violated this policy may be subject to disciplinary action up to and including termination of the account.
			</p>
			<br/>
			<h2>Definitions</h2>
			<table border="1">
		  		<tr>
			    	<th>Term</th>
			    	<th>Defnition</th>
				</tr>
				<tr>
					<td>Spam</td>
					<td>Electronic junk mail or junk newsgroup postings. Messages that are unsolicited, unwanted, and irrelevant.</td>
				</tr>
			</table>
			<br/>
			
			<h2>Revision History</h2>
			<table border="1">
		  		<tr>
			    	<th>Date Of Change</th>
			    	<th>Responsible</th>
					<th>Summary of Change</th>
				</tr>
				<tr>
					<td>2016-12-01</td>
					<td><?php echo WEBSITE_NAME; ?></td>
					<td>Policy Created</td>
				</tr>
			</table>
			<br/>
        </div>
</section>
		
<?php include 'footer.php'; ?>
