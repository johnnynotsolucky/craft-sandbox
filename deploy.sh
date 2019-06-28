
echo "Creating Ansible Vault password file"
cat <<EOF > ./.ansible_vault_password
${ANSIBLE_VAULT_PASSWORD}
EOF

ansible-playbook --private-key .deploy_key \
  -u website \
  -i inventory \
  --vault-password-file ./.ansible-vault-password \
  deploy.yml
