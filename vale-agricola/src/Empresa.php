<?php

class Empresa implements ActiveRecord
{

    private int $idEmpresa;
    private string $nome;
    private string $senha;
    private string $email;
    private string $cnpj;
    
    

    public function __construct() {}
        
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

    /* Consulta com processo de segurança contra SQL Inject
    
    public static function find($id): Empresa
{
    $connection = new MySQL();
    $stmt = $connection->prepare("SELECT * FROM empresa WHERE idEmpresa = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    
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
*/

    public static function findall():array{
        $conexao = new MySQL();
        $sql = "SELECT * FROM empresa";
        $resultados = $conexao->consulta($sql);
        $empresas = array();
        foreach($res as $resultado){
            $e = new Empresa;
            // $e = new Empresa($resultado['nome'],$resultado['email'],$resultado['email']);
            $e->constructorCreate(
                $res['nome'],
                $res['senha'],
                $res['email'],
                $res['cnpj']
            );
            $e->setIdEmpresa($resultado['id']);
            $empresas[] = $e;
        }           
        return $empresas;
    }

    public function authenticate(): bool
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


}