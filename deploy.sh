
echo "Creating Ansible Vault password file"
cat <<EOF > ./.ansible_vault_password
${ANSIBLE_VAULT_PASSWORD}
EOF

cd ${TRAVIS_BUILD_DIR}
echo ${TRAVIS_BUILD_DIR}

ansible-playbook --private-key .deploy_key \
  -u website \
  -i infrastructure/ansible/inventories/staging \
  --vault-password-file ./.ansible_vault_password \
  infrastructure/ansible/deploy.yml
