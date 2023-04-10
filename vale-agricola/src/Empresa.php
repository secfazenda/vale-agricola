<?php

class Empresa implements ActiveRecord{

    private int $idEmpresa;
    private string $nome;
    private string $senha;
    private string $email;
    private int $cnpj;
    
    

    public function __construct() {}
        
    public function constructorCreate(
        string $nome,
        string $senha,
        string $email,
        int $cnpj

    ): void{

        $this->setNome($nome);
        $this->setSenha($senha);
        $this->setEmail($email);
        $this->setCnpj($cnpj);        
        
    }


    public function constructLogin(string $email, string $senha): void
    {
        $this->setEmail($email);
        $this->setSenha($senha);
    }

    public function setIdEmpresa(int $idEmpresa): void{
        $this->idEmpresa = $idEmpresa;
    }

    public function getIdEmpresa(): int{
        return $this->idEmpresa;
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
        
        if (isset($this->idEmpresa)) {
          $sql = "UPDATE empresa SET nome = '{$this->nome}', email = '{$this->email}', cnpj = '{$this->cnpj}'   WHERE idEmpresa = {$this->idEmpresa}";
        }

        else {
            $this->senha = password_hash($this->senha,PASSWORD_BCRYPT);
            $sql = "INSERT INTO empresa (nome,senha,email,cnpj) VALUES ('{$this->nome}','{$this->senha}','{$this->email}','{$this->cnpj}')";
        }
        
        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM empresa WHERE idEmpresa = {$this->idEmpresa}";
        return $connection->execute($sql);
    }

    public static function find($id): Empresa
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM empresa WHERE idEmpresa = {$id}";
        $res = $connection->query($sql);
        $empresa = new Empresa;
        $empresa->constructorCreate(
            $res[0]['nome'],
            $res[0]['senha'],
            $res[0]['email'],
            $res[0]['cnpj']
        );
        $empresa->setIdEmpresa($res[0]['idEmpresa']);
        
        return $empresa;
    }


}