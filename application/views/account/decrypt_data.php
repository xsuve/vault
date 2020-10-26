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
            <div class="col-lg-6">
              <div class="form">
                <form action="<?php echo URL; ?>account/<?php echo $account->id; ?>" method="post">
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
                    <small class="form-text text-muted">Data is encrypted with a key. Enter the encryption key that this account data has been encrypted with. If this is a shared account, ask the account owner for the key.</small>
                  </div>
                  <button type="submit" name="submit_decrypt_data" class="btn btn-primary">Decrypt Account Data</button>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

  <!-- Container End -->
  </div>
</div>
