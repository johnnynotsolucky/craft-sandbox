
Use Terraform to provision a server to test on

```bash
cd infrastructure/terraform/single
source ../.env
terraform plan \
  -var "do_token=${DIGITALOCEAN_TOKEN}" \
  -var "ssh_fingerprint=${SSH_FINGERPRINT}" \
  -var "base_domain=${BASE_DOMAIN}" \
  -var "sub_domain=${SUB_DOMAIN}" \

terraform apply --auto-approve \
  -var "do_token=${DIGITALOCEAN_TOKEN}" \
  -var "ssh_fingerprint=${SSH_FINGERPRINT}" \
  -var "base_domain=${BASE_DOMAIN}" \
  -var "sub_domain=${SUB_DOMAIN}" \
```

Ansible Playbook:

```bash
$ ansible-playbook -i infrastructure/ansible/inventories/staging --vault-password-file ~/ansible-vault-password  infrastructure/ansible/provision.yml

$ ansible-playbook -i infrastructure/ansible/inventories/staging --vault-password-file ~/ansible-vault-password  infrastructure/ansible/deploy.yml
```
