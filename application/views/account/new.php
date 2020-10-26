    <!-- Account -->
    <div class="col-lg-9 p-lg-0 p-0">
      <div class="dashboard">
        <div class="dashboard-top-bar pl-lg-4 pr-lg-4 pt-lg-3 pb-lg-3">
					<div class="row">
						<div class="col-lg-6">
							<div class="dashboard-top-bar-back-link v-m">
                <a href="<?php echo URL; ?>">
                  <i data-feather="chevron-left"></i>
                  <span>Back</span>
                </a>
              </div>
						</div>
					</div>
				</div>

        <form action="<?php echo URL; ?>account/newaccount" method="post">
          <div class="dashboard-body p-lg-5">
            <div class="row">
              <div class="col-lg-6 text-left">
                <div class="dashboard-body-account-title mb-lg-2">Add new account</div>
                <div class="dashboard-body-account-text">Complete the fields below in order to create a new account.<br><br>You can complete only the fields that you need. They are not all required, only the ones from the General tab.</div>
              </div>
              <div class="col-lg-6 text-right">
                <div class="v-m">
                  <button type="submit" name="submit_add_account" class="btn btn-primary" id="addAccountBtn" disabled>Add Account</button>
                </div>
              </div>
            </div>
            <div class="dashboard-body-account-tab-links mt-lg-5">
              <div class="row">
                <div class="col-lg-12 text-left">
                  <div class="dashboard-body-account-tab-link active" data-tab="general">General</div>
                  <div class="dashboard-body-account-tab-link" data-tab="cpanel">cPanel</div>
                  <div class="dashboard-body-account-tab-link" data-tab="ftp">FTP</div>
                  <div class="dashboard-body-account-tab-link" data-tab="mysql">MySQL</div>
                  <div class="dashboard-body-account-tab-link" data-tab="email">Email</div>
                  <div class="dashboard-body-account-tab-link" data-tab="wordpress">WordPress <span class="badge badge-primary ml-lg-1">PRO</span></div>
                </div>
              </div>
            </div>

            <div class="dashboard-body-account-tabs form mt-lg-5">

              <!-- General -->
              <div class="dashboard-body-account-tab active" data-tab="general">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group encryption-key-input mb-lg-5 mb-5">
                      <label for="accountEncryptionKey">Encryption Key</label>
                      <div class="input-group">
                        <input type="password" name="account_encryption_key" class="form-control" id="accountEncryptionKey" placeholder="Encryption Key (ex. 123456)">
                        <div class="input-group-append">
                          <span class="input-group-text show-encryption-key active">
                            <i data-feather="eye" width="18" height="18"></i>
                          </span>
                          <span class="input-group-text hide-encryption-key">
                            <i data-feather="eye-off" width="18" height="18"></i>
                          </span>
                        </div>
                      </div>
                      <small class="form-text text-muted">Data needs to be encrypted with a key. You need to send this key to all users you share this account with. Make sure you don't lose it and only share it with who you trust. If this key is lost, the data can't be recovered. Required field.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountTitle">Title</label>
                      <input type="text" name="account_title" class="form-control" id="accountTitle" placeholder="Title (ex. My Account)">
                      <small class="form-text text-muted">A title to differentiate between accounts. Required field.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountDomainURL">Domain URL</label>
                      <input type="text" name="account_domain_url" class="form-control" id="accountDomainURL" placeholder="Domain URL (ex. myaccount.com)">
                      <small class="form-text text-muted">The domain URL of your account. Required field.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountExpirationDate">Expiration Date</label>
                      <input type="date" name="account_expiration_date" class="form-control" id="accountExpirationDate" placeholder="Expiration Date (YYYY-MM-DD) (ex. 1970-01-01)" min="<?php echo date('Y-m-d'); ?>">
                      <small class="form-text text-muted">The date when this account's domain will expire. Required field.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountIPAddress">IP Address</label>
                      <input type="text" name="account_ip_address" class="form-control" id="accountIPAddress" placeholder="IP Address (ex. 127.0.0.1)">
                      <small class="form-text text-muted">The IP address of this account, without any port. Required field.</small>
                    </div>
                  </div>
                </div>
              </div>

              <!-- cPanel -->
              <div class="dashboard-body-account-tab" data-tab="cpanel">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountCPanelPort">cPanel Port</label>
                      <input type="text" name="account_cpanel_port" class="form-control" id="accountCPanelPort" placeholder="cPanel Port  (ex. 2083)" value="2083">
                      <small class="form-text text-muted">The port of the account's cPanel.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountCPanelUsername">cPanel Username</label>
                      <input type="text" name="account_cpanel_username" class="form-control" id="accountCPanelUsername" placeholder="cPanel Username (ex. myaccountcom)">
                      <small class="form-text text-muted">The username of the account's cPanel.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountCPanelPassword">cPanel Password</label>
                      <input type="password" name="account_cpanel_password" class="form-control" id="accountCPanelPassword" placeholder="cPanel Password (ex. 123456)">
                      <small class="form-text text-muted">The password of the account's cPanel.</small>
                    </div>
                  </div>
                </div>
              </div>

              <!-- FTP -->
              <div class="dashboard-body-account-tab" data-tab="ftp">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountFTPPort">FTP Port</label>
                      <input type="text" name="account_ftp_port" class="form-control" id="accountFTPPort" placeholder="FTP Port (ex. 21)" value="21">
                      <small class="form-text text-muted">The port of the account's FTP.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountFTPUsername">FTP Username</label>
                      <input type="text" name="account_ftp_username" class="form-control" id="accountFTPUsername" placeholder="FTP Username (ex. myaccountftp)">
                      <small class="form-text text-muted">The username of the account's FTP.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountFTPPassword">FTP Password</label>
                      <input type="password" name="account_ftp_password" class="form-control" id="accountFTPPassword" placeholder="FTP Password (ex. 123456)">
                      <small class="form-text text-muted">The password of the account's FTP.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountFTPPath">FTP Path</label>
                      <input type="text" name="account_ftp_path" class="form-control" id="accountFTPPath" placeholder="FTP Path (ex. /home/public_html)">
                      <small class="form-text text-muted">The path of the account's FTP.</small>
                    </div>
                  </div>
                </div>
              </div>

              <!-- MySQL -->
              <div class="dashboard-body-account-tab" data-tab="mysql">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountMySQLHost">MySQL Host</label>
                      <input type="text" name="account_mysql_host" class="form-control" id="accountMySQLHost" placeholder="MySQL Host (ex. localhost)" value="localhost">
                      <small class="form-text text-muted">The host of the account's MySQL.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountMySQLPort">MySQL Port</label>
                      <input type="text" name="account_mysql_port" class="form-control" id="accountMySQLPort" placeholder="MySQL Port (ex. 3306)" value="3306">
                      <small class="form-text text-muted">The port of the account's MySQL.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountMySQLUsername">MySQL Username</label>
                      <input type="text" name="account_mysql_username" class="form-control" id="accountMySQLUsername" placeholder="MySQL Username (ex. myaccountmysql)">
                      <small class="form-text text-muted">The username of the account's MySQL.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountMySQLPassword">MySQL Password</label>
                      <input type="password" name="account_mysql_password" class="form-control" id="accountMySQLPassword" placeholder="MySQL Password (ex. 123456)">
                      <small class="form-text text-muted">The password of the account's MySQL.</small>
                    </div>
                  </div>
                </div>
              </div>

              <!-- E-mail -->
              <div class="dashboard-body-account-tab" data-tab="email">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailUsername">Email Username</label>
                      <input type="text" name="account_email_username" class="form-control" id="accountEmailUsername" placeholder="Email Username (ex. myaccountemail)">
                      <small class="form-text text-muted">The username of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailPassword">Email Password</label>
                      <input type="password" name="account_email_password" class="form-control" id="accountEmailPassword" placeholder="Email Password (ex. 123456)">
                      <small class="form-text text-muted">The password of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailSMTPURL">Email SMTP URL</label>
                      <input type="text" name="account_email_smtp_url" class="form-control" id="accountEmailSMTPURL" placeholder="Email SMTP URL (ex. mail.myaccount.com)">
                      <small class="form-text text-muted">The SMTP URL of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailSMTPPort">Email SMTP Port</label>
                      <input type="text" name="account_email_smtp_port" class="form-control" id="accountEmailSMTPPort" placeholder="Email SMTP Port (ex. 25)" value="25">
                      <small class="form-text text-muted">The SMTP Port of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailIMAPURL">Email IMAP URL</label>
                      <input type="text" name="account_email_imap_url" class="form-control" id="accountEmailIMAPURL" placeholder="Email IMAP URL (ex. mail.myaccount.com)">
                      <small class="form-text text-muted">The IMAP URL of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailIMAPPort">Email IMAP Port</label>
                      <input type="text" name="account_email_imap_port" class="form-control" id="accountEmailIMAPPort" placeholder="Email IMAP Port (ex. 143)" value="143">
                      <small class="form-text text-muted">The IMAP Port of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailPOP3URL">Email POP3 URL</label>
                      <input type="text" name="account_email_pop3_url" class="form-control" id="accountEmailPOP3URL" placeholder="Email POP3 URL (ex. mail.myaccount.com)">
                      <small class="form-text text-muted">The POP3 URL of the account's email.</small>
                    </div>
                    <div class="form-group mb-lg-4 mb-4">
                      <label for="accountEmailPOP3Port">Email POP3 Port</label>
                      <input type="text" name="account_email_pop3_port" class="form-control" id="accountEmailPOP3Port" placeholder="Email POP3 Port (ex. 110)" value="110">
                      <small class="form-text text-muted">The POP3 Port of the account's email.</small>
                    </div>
                  </div>
                </div>
              </div>

              <!-- WordPress -->
              <div class="dashboard-body-account-tab" data-tab="wordpress">
                <div class="row">
                  <?php if($wordpress_account_details != 0): ?>
                    <div class="col-lg-6">
                      <div class="form-group mb-lg-4 mb-4">
                        <label for="accountWordPressAdminURL">WordPress Admin URL</label>
                        <input type="text" name="account_wordpress_admin_url" class="form-control" id="accountWordPressAdminURL" placeholder="WordPress Admin URL (ex. myaccount.com/wp-admin)">
                        <small class="form-text text-muted">The Wordpress admin URL to login into the dashboard.</small>
                      </div>
                      <div class="form-group mb-lg-4 mb-4">
                        <label for="accountWordPressAdminUsername">WordPress Admin Username</label>
                        <input type="text" name="account_wordpress_admin_username" class="form-control" id="accountWordPressAdminUsername" placeholder="WordPress Admin Username (ex. myaccountwp)">
                        <small class="form-text text-muted">The Wordpress admin username to login into the dashboard.</small>
                      </div>
                      <div class="form-group mb-lg-4 mb-4">
                        <label for="accountWordPressAdminPassword">WordPress Admin Password</label>
                        <input type="password" name="account_wordpress_admin_password" class="form-control" id="accountWordPressAdminPassword" placeholder="WordPress Admin Password (ex. 123456)">
                        <small class="form-text text-muted">The Wordpress admin password to login into the dashboard.</small>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="col-lg-6">
                      <div class="dashboard-body-account-text mb-lg-4">Your plan does not include this feature. Consider upgrading to Vault Pro to get this feature.</div>
                      <div class="dashboard-body-upgrade-plan p-lg-4 p-4 text-left">
                        <div class="dashboard-body-upgrade-plan-mask">
                          <i data-feather="star"></i>
                        </div>
                        <div class="dashboard-body-upgrade-plan-title mb-lg-2 mb-2">Upgrade to Vault Pro</div>
                        <div class="dashboard-body-upgrade-plan-text mb-lg-4 mb-4">Get unlimited features for only $<?php echo VAULT_PRO_PRICE; ?> / mo!</div>
                        <a href="<?php echo URL; ?>profile/upgrade"><button type="button" class="btn btn-light">Upgrade Plan</button></a>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>

            </div>

          </div>
        </form>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
