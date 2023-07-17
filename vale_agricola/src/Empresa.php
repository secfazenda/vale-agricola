<?php

class Empresa implements ActiveRecord
{

    private int $idEmpresa;
    private string $nome;
    private string $senha;
    private string $email;
    private string $cnpj;
    private string $novaSenha;
    private int $habilitada;
      
    public function __construct()
    {
        $this->habilitada = 0; // Inicializa a propriedade $habilitada com um valor padrão (por exemplo, 0)
    }
        
    public function constructorCreate(
        string $nome,
        string $senha,
        string $email,
        string $cnpj
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

    public function setCnpj(string $cnpj): void{
        $this->cnpj = $cnpj;
    }

    public function getCnpj(): string{
        return $this->cnpj;
    }

    public function setEmail(string $email): void{
        $this->email = $email;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function setSenha(string $senha): void{
        $this->senha = $senha;
    }

    public function getSenha(): string{
        return $this->senha;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setHabilitada(int $habilitada): void
    {
        $this->habilitada = $habilitada;
    }

    public function getHabilitada(): int
    {
        return $this->habilitada;
    }

    public function save(): bool
    {
        $connection = new MySQL();

        if (isset($this->idEmpresa)) {
            $sql = "UPDATE empresa SET nome = '{$this->nome}', email = '{$this->email}', cnpj = '{$this->cnpj}', habilitada = {$this->habilitada} WHERE idEmpresa = {$this->idEmpresa}";
        } else {
            $this->senha = password_hash($this->senha, PASSWORD_BCRYPT);
            $sql = "INSERT INTO empresa (nome, senha, email, cnpj, habilitada) VALUES ('{$this->nome}', '{$this->senha}', '{$this->email}', '{$this->cnpj}', {$this->habilitada})";
        }

        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM documento WHERE idEmpresa = {$this->idEmpresa}";
        $connection->execute($sql);
        
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

    public static function findall($idEmpresa = null): array
{
    $connection = new MySQL();
    $sql = "SELECT * FROM empresa";

    if ($idEmpresa !== null) {
        $sql .= " WHERE idEmpresa = {$idEmpresa}";
    }

    $results = $connection->query($sql);
    $empresas = [];

    foreach ($results as $res) {
        $e = new Empresa();
        $e->setIdEmpresa($res['idEmpresa']);
        $e->setNome($res['nome']);
        $e->setSenha($res['senha']);
        $e->setEmail($res['email']);
        $e->setCnpj($res['cnpj']);
        $e->setHabilitada($res['habilitada']);
        $empresas[] = $e;
    }

    return $empresas;
}


    public function authenticate($id_empresa): bool
{
    $connection = new MySQL();
    $sql = "SELECT idEmpresa, nome, senha, cnpj FROM empresa WHERE email = '{$this->email}'";
    $results = $connection->query($sql);
    
    if (password_verify($this->senha, $results[0]["senha"])) {
        session_start();
        $_SESSION['idEmpresa'] = $results[0]['idEmpresa'];
        $_SESSION['nome'] = $results[0]['nome'];
        $_SESSION['email'] = $results[0]['email'];
        $_SESSION['cnpj'] = $results[0]['cnpj'];
        
        return true;
    } else {
        return false;
    }
}


    public function atualizarSenha(string $novaSenha): bool
    {
        $this->setSenha($novaSenha);

        $connection = new MySQL();
        $this->senha = password_hash($this->senha, PASSWORD_BCRYPT);

        $sql = "UPDATE empresa SET senha = '{$this->senha}' WHERE idEmpresa = {$this->idEmpresa}";
        return $connection->execute($sql);
    }

    public static function findHabilitadas(): array
{
    $connection = new MySQL();
    $sql = "SELECT * FROM empresa WHERE habilitada = 1";
    $results = $connection->query($sql);
    $empresas = [];

    foreach ($results as $res) {
        $e = new Empresa();
        $e->setIdEmpresa($res['idEmpresa']);
        $e->setNome($res['nome']);
        $e->setSenha($res['senha']);
        $e->setEmail($res['email']);
        $e->setCnpj($res['cnpj']);
        $e->setHabilitada($res['habilitada']);
        $empresas[] = $e;
    }

    return $empresas;
}

}