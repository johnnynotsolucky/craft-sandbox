
echo "Creating Ansible Vault password file"
cat <<EOF > ./.ansible_vault_password
${ANSIBLE_VAULT_PASSWORD}
EOF

ansible-playbook --private-key .deploy_key \
  -u website \
  -i infrastructure/ansible/inventories/staging \
  --vault-password-file ./.ansible_vault_password \
  infrastructure/ansible/deploy.yml
