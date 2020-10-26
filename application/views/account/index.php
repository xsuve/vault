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

        <div class="dashboard-body p-lg-5">
          <div class="row">
            <div class="col-lg-6 text-left">
              <div class="dashboard-body-account-title mb-lg-2"><?php echo $account->title; ?></div>
              <?php if($is_shared_account): ?>
                <div class="dashboard-body-account-text">Shared with you by <?php echo $shared_account_owner_user_email->email; ?>.</div>
              <?php else: ?>
                <div class="dashboard-body-account-text">Needs to be renewed before <?php echo date('j F, Y', strtotime($account->expiration_date)); ?></div>
              <?php endif; ?>
            </div>
            <!-- <div class="col-lg-6 text-right">
              <div class="v-m">
                <a href="<?php echo URL; ?>account/edit/<?php echo $account->id; ?>"><button class="btn btn-outline-primary">Edit Account</button></a>
              </div>
            </div> -->
          </div>
          <div class="dashboard-body-account-tab-links mt-lg-5">
            <div class="row">
              <div class="col-lg-6 text-left">
                <?php if(!empty($account->cpanel_username)): ?>
                  <div class="dashboard-body-account-tab-link active" data-tab="cpanel">cPanel</div>
                <?php endif; ?>
                <?php if(!empty($account->ftp_username)): ?>
                  <div class="dashboard-body-account-tab-link" data-tab="ftp">FTP</div>
                <?php endif; ?>
                <?php if(!empty($account->mysql_username)): ?>
                  <div class="dashboard-body-account-tab-link" data-tab="mysql">MySQL</div>
                <?php endif; ?>
                <?php if(!empty($account->email_username)): ?>
                  <div class="dashboard-body-account-tab-link" data-tab="email">Email</div>
                <?php endif; ?>
                <?php if(!empty($account->wordpress_admin_username)): ?>
                  <div class="dashboard-body-account-tab-link" data-tab="wordpress">WordPress</div>
                <?php endif; ?>
              </div>
              <div class="col-lg-6 text-right">
                <div class="dashboard-body-account-tab-link <?php echo ($is_shared_account ? 'mr-lg-0 mr-0' : ''); ?>" data-tab="team">Team <span class="badge badge-primary ml-lg-1"><?php echo count($account_shared_users); ?></span></div>
                <?php if(!$is_shared_account): ?>
                  <a href="<?php echo URL; ?>account/edit/<?php echo $account->id; ?>"><div class="dashboard-body-account-tab-link ml-lg-5">Edit</div></a>
                  <div class="dashboard-body-account-tab-link" data-tab="delete">Delete</div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="dashboard-body-account-tabs mt-lg-5">

            <!-- cPanel -->
            <?php if(!empty($account->cpanel_username)): ?>
              <div class="dashboard-body-account-tab active" data-tab="cpanel">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">IP Address</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->ip_address; ?>" data-info-type="cpanel" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <a href="http://<?php echo $account->ip_address; ?>:<?php echo $account->cpanel_port; ?>" target="_blank"><i data-feather="external-link" class="mr-lg-3"></i></a>
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">cPanel Port</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->cpanel_port; ?>" data-info-type="cpanel" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">cPanel Username</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->cpanel_username; ?>" data-info-type="cpanel" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info">
                          <div class="dashboard-body-account-info-title mb-lg-2">cPanel Password</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->cpanel_password; ?>" data-info-type="cpanel" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard-body-account-general-actions mb-lg-5 mb-5">
                      <i data-feather="eye" class="show-all-info mr-lg-4" data-info-type="cpanel"></i>
                      <i data-feather="eye-off" class="hide-all-info mr-lg-4" data-info-type="cpanel"></i>
                      <i data-feather="download" class="download-all-info" data-info-type="cpanel"></i>
                      <div class="actions-delimiter"></div>
                      <i data-feather="slack" class="slack-all-info mr-lg-4" data-info-type="cpanel"></i>
                      <i data-feather="trello" class="trello-all-info" data-info-type="cpanel"></i>
                    </div>
                    <div class="dashboard-body-account-text mb-lg-4 mb-4">Get the details available to log into the cPanel of this account.<br><br>cPanel Connect allows you to quickly connect to the cPanel by a click of the button below. Coming soon - available only for Vault Pro users.</div>
                    <!-- <a href="<?php echo URL; ?>account/cpanelconnect/<?php echo $account->id; ?>" target="_blank"> -->
                      <button class="btn btn-primary">cPanel Connect</button>
                    <!-- </a> -->
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- FTP -->
            <?php if(!empty($account->ftp_username)): ?>
              <div class="dashboard-body-account-tab" data-tab="ftp">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">IP Address</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->ip_address; ?>" data-info-type="ftp" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <a href="http://<?php echo $account->ip_address; ?>:<?php echo $account->ftp_port; ?>" target="_blank"><i data-feather="external-link" class="mr-lg-3"></i></a>
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">FTP Port</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->ftp_port; ?>" data-info-type="ftp" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">FTP Username</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->ftp_username; ?>" data-info-type="ftp" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info">
                          <div class="dashboard-body-account-info-title mb-lg-2">FTP Password</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->ftp_password; ?>" data-info-type="ftp" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info">
                          <div class="dashboard-body-account-info-title mb-lg-2">FTP Path</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->ftp_path; ?>" data-info-type="ftp" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard-body-account-general-actions mb-lg-5 mb-5">
                      <i data-feather="eye" class="show-all-info mr-lg-4" data-info-type="ftp"></i>
                      <i data-feather="eye-off" class="hide-all-info mr-lg-4" data-info-type="ftp"></i>
                      <i data-feather="download" class="download-all-info" data-info-type="ftp"></i>
                      <div class="actions-delimiter"></div>
                      <i data-feather="slack" class="slack-all-info mr-lg-4" data-info-type="ftp"></i>
                      <i data-feather="trello" class="trello-all-info" data-info-type="ftp"></i>
                    </div>
                    <div class="dashboard-body-account-text mb-lg-4">Get the details available to log into the FTP of this account.</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- MySQL -->
            <?php if(!empty($account->mysql_username)): ?>
              <div class="dashboard-body-account-tab" data-tab="mysql">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">MySQL Host</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->mysql_host; ?>" data-info-type="mysql" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">MySQL Port</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->mysql_port; ?>" data-info-type="mysql" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">MySQL Username</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->mysql_username; ?>" data-info-type="mysql" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info">
                          <div class="dashboard-body-account-info-title mb-lg-2">MySQL Password</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->mysql_password; ?>" data-info-type="mysql" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard-body-account-general-actions mb-lg-5 mb-5">
                      <i data-feather="eye" class="show-all-info mr-lg-4" data-info-type="mysql"></i>
                      <i data-feather="eye-off" class="hide-all-info mr-lg-4" data-info-type="mysql"></i>
                      <i data-feather="download" class="download-all-info" data-info-type="mysql"></i>
                      <div class="actions-delimiter"></div>
                      <i data-feather="slack" class="slack-all-info mr-lg-4" data-info-type="mysql"></i>
                      <i data-feather="trello" class="trello-all-info" data-info-type="mysql"></i>
                    </div>
                    <div class="dashboard-body-account-text mb-lg-4">Get the details available to log into the MySQL database of this account.</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- E-mail -->
            <?php if(!empty($account->email_username)): ?>
              <div class="dashboard-body-account-tab" data-tab="email">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email Username</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_username; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email Password</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_password; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email SMTP URL</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_smtp_url; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email SMTP Port</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_smtp_port; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email IMAP URL</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_imap_url; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email IMAP Port</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_imap_port; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email POP3 URL</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_pop3_url; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">Email POP3 Port</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->email_pop3_port; ?>" data-info-type="email" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard-body-account-general-actions mb-lg-5 mb-5">
                      <i data-feather="eye" class="show-all-info mr-lg-4" data-info-type="email"></i>
                      <i data-feather="eye-off" class="hide-all-info mr-lg-4" data-info-type="email"></i>
                      <i data-feather="download" class="download-all-info" data-info-type="email"></i>
                      <div class="actions-delimiter"></div>
                      <i data-feather="slack" class="slack-all-info mr-lg-4" data-info-type="email"></i>
                      <i data-feather="trello" class="trello-all-info" data-info-type="email"></i>
                    </div>
                    <div class="dashboard-body-account-text mb-lg-4">Get the details available for the email accounts of this account.</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- WordPress -->
            <?php if(!empty($account->wordpress_admin_username)): ?>
              <div class="dashboard-body-account-tab" data-tab="wordpress">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="row">
                      <div class="col-lg-12 mb-lg-5">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">WordPress Admin URL</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->wordpress_admin_url; ?>" data-info-type="wordpress" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <a href="<?php echo $account->wordpress_admin_url; ?>" target="_blank"><i data-feather="external-link" class="mr-lg-3"></i></a>
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">WordPress Admin Username</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->wordpress_admin_username; ?>" data-info-type="wordpress" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6">
                        <div class="dashboard-body-account-info mb-lg-4">
                          <div class="dashboard-body-account-info-title mb-lg-2">WordPress Admin Password</div>
                          <input type="text" class="dashboard-body-account-info-input mb-lg-2" data-info="<?php echo $account->wordpress_admin_password; ?>" data-info-type="wordpress" value="********************" readonly>
                          <div class="dashboard-body-account-info-action">
                            <i data-feather="eye" class="show-info mr-lg-3"></i>
                            <i data-feather="eye-off" class="hide-info mr-lg-3"></i>
                            <i data-feather="copy" class="copy-info"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="dashboard-body-account-general-actions mb-lg-5 mb-5">
                      <i data-feather="eye" class="show-all-info mr-lg-4" data-info-type="wordpress"></i>
                      <i data-feather="eye-off" class="hide-all-info mr-lg-4" data-info-type="wordpress"></i>
                      <i data-feather="download" class="download-all-info" data-info-type="wordpress"></i>
                      <div class="actions-delimiter"></div>
                      <i data-feather="slack" class="slack-all-info mr-lg-4" data-info-type="wordpress"></i>
                      <i data-feather="trello" class="trello-all-info" data-info-type="wordpress"></i>
                    </div>
                    <div class="dashboard-body-account-text mb-lg-4">Get the details available to log into the WordPress admin of this account.</div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Team -->
            <div class="dashboard-body-account-tab" data-tab="team">
              <div class="row">
                <div class="col-lg-6">
                  <?php if(count($account_shared_users) > 0): ?>
                    <div class="dashboard-body-team-users">
                      <?php foreach($account_shared_users as $account_shared_user): ?>
                        <?php
                          $shared_account_user = $account_model->getSharedAccountUser($account_shared_user->user_id);
                        ?>
                        <div class="dashboard-body-team-user p-lg-4 p-4">
                          <?php if(!$is_shared_account): ?>
                            <a href="<?php echo URL; ?>account/removeshared/<?php echo $account_shared_user->id; ?>/<?php echo $account->id; ?>">
                              <div class="dashboard-body-team-user-remove">
                                <i data-feather="x" class="v-m"></i>
                              </div>
                            </a>
                          <?php endif; ?>
                          <div class="row">
                            <div class="col-lg-3 col-3">
                              <div class="dashboard-body-team-user-image v-m">
                                <img src="<?php echo (empty($shared_account_user->profile_url) ? URL . 'public/img/user.png' : $shared_account_user->profile_url); ?>">
                              </div>
                            </div>
                            <div class="col-lg-9 col-9">
                              <div class="v-m">
                                <div class="dashboard-body-team-user-title"><?php echo ($account_shared_user->user_id == $user->id ? 'You' : $shared_account_user->email); ?></div>
                                <div class="dashboard-body-team-user-text">Privileges: <?php echo $shared_account_user->privileges; ?></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                </div>
                <?php if(!$is_shared_account): ?>
                  <?php if(count($account_shared_users) < $max_shared_users_per_account): ?>
                    <div class="col-lg-6">
                      <div class="dashboard-body-account-text mb-lg-4">Vault allows you to share accounts details between users of the platform. Enter the email address of the user you want to share the connection details of this account with.</div>
                      <div class="form">
                        <form action="<?php echo URL; ?>account/shareaccount/<?php echo $account->id; ?>" method="post">
                          <div class="form-group mb-lg-4 mb-4">
                            <label for="accountUserEmail">User Email</label>
                            <input type="hidden" value="<?php echo $account->id; ?>" id="accountUserEmailAccountID">
                            <select name="user_email" class="form-control" id="accountUserEmail">
                            </select>
                            <small class="form-text text-muted">The email address of the user you want to share this account with.</small>
                          </div>
                          <button type="submit" name="submit_share_account" class="btn btn-primary" id="accountUserEmailBtn" disabled>Share Account</button>
                        </form>
                      </div>
                    </div>
                  <?php else: ?>
                    <div class="col-lg-6">
                      <div class="dashboard-body-account-text mb-lg-4">This account has reached the maximum shared users per account plan limit. Consider upgrading to Vault Pro to lift this limit.</div>
                      <div class="dashboard-body-upgrade-plan p-lg-4 p-4 text-left">
                        <div class="dashboard-body-upgrade-plan-mask">
                          <i data-feather="star"></i>
                        </div>
                        <div class="dashboard-body-upgrade-plan-title mb-lg-2 mb-2">Upgrade to Vault Pro</div>
                        <div class="dashboard-body-upgrade-plan-text mb-lg-4 mb-4">Get unlimited features for only $<?php echo VAULT_PRO_PRICE; ?> / mo!</div>
                        <a href="<?php echo URL; ?>profile/upgrade"><button class="btn btn-light">Upgrade Plan</button></a>
                      </div>
                    </div>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
            </div>

            <!-- Delete -->
            <div class="dashboard-body-account-tab form" data-tab="delete">
              <div class="row">
                <div class="col-lg-6">
                  <div class="dashboard-body-account-text mb-lg-4">You are about to delete this account. All the connection details will be deleted along with this account.<br><br>To confirm you truly want to proceed with this action, please type in the title of this account ( <strong><?php echo $account->title; ?></strong> ):</div>
                  <div class="form-group mb-lg-4 mb-4">
                    <input type="text" class="form-control" id="deleteAccountInput" placeholder="Account Title (ex. myaccount)" data-account-title="<?php echo $account->title; ?>">
                  </div>
                  <a href="javascript:void(0);" data-href="<?php echo URL; ?>account/delete/<?php echo $account->id; ?>" id="deleteAccountLink">
                    <button class="btn btn-primary" id="deleteAccountBtn" disabled>Delete Account</button>
                  </a>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
