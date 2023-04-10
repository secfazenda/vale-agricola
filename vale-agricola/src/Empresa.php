<?php

class Empresa implements ActiveRecord{

    private int $cnpj;
    private string $email;
    private string $senha;
    private string $nome;

    public function __construct() {}
        
    public function constructorCreate(
        int $cnpj,
        string $email,
        string $senha,
        string $nome

    ): void{

        $this->setCnpj($cnpj);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setNome($nome);
    }


    public function constructLogin(string $email, string $senha): void
    {
        $this->setEmail($email);
        $this->setSenha($senha);
    }

    public function setCnpj(int $cnpj): void{
        $this->cnpj = $cnpj;
    }

    public function getCnpj(): int{
        return $this->cnpj;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function getEmail(): int{
        return $this->email;
    }

    public function setSenha(string $senha): void{
        $this->senha = $senha;
    }

    public function getSenha(): int{
        return $this->senha;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function getNome(): string{
        $this->email = $nome;
    }

    public function save(): bool 
    {
        $connection = new MySQL();
        
        if (isset($this->cnpj)) {
          $sql = "UPDATE empresa SET email = '{$this->email}', nome = '{$this->nome}' WHERE cnpj = {$this->cnpj}";
        }

        else {
            $this->senha = password_hash($this->senha,PASSWORD_BCRYPT);
            $sql = "INSERT INTO empresa (cnpj,email,senha,nome) VALUES ('{$this->cnpj}','{$this->email}','{$this->senha}','{$this->nome}')";
        }
        
        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM empresa WHERE cnpj = {$this->cnpj}";
        return $connection->execute($sql);
    }

    public static function find($cnpj): Empresa
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM empresa WHERE cnpj = {$cnpj}";
        $res = $connection->query($sql);
        $empresa = new Empresa;
        $empresa->constructorCreate(
            $res[0]['cnpj'],
            $res[0]['email'],
            $res[0]['nickname'],
            $res[0]['senha']
        );
        $empresa->setCnpj($res[0]['cnpj']);
        
        return $empresa;
    }


}