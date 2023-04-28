<?php

class Documento implements ActiveRecord{

    private int $idDocumento;
    private string $nome;
    private ?DateTime $validade;
    private ?string $pdf;
    private int $idEmpresa;
    
    public function __construct() {
        // $this->validade = new DateTime();
    }
    
    public function constructorCreate(
        string $nome, 
        ?DateTime $validade, 
        ?string $pdf
    ): self {
        
        if ($validade === null) {
            $validade = new DateTime(); // cria um objeto DateTime com a data atual
        }
        $this->nome = $nome;
        $this->validade = $validade;
        $this->pdf = $pdf;
        return $this;
    }

    public function setIdDocumento(int $idDocumento): void{
        $this->idDocumento = $idDocumento;
    }

    public function getIdDocumento(): int{
        return $this->idDocumento;
    }

    public function setNome(string $nome): void{
        $this->nome = $nome;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setValidade(?DateTime $validade): void{
        $this->validade = $validade;
    }

    public function getValidade(): ?DateTime{
        return $this->validade;
    }

    public function setPdf(?string $pdf): void{
        $this->pdf = $pdf;
    }

    public function getPdf(): ?string{
        return $this->pdf;
    }

    public function setIdEmpresa(int $idEmpresa): void{
        $this->idEmpresa = $idEmpresa;
    }

    public function getIdEmpresa(): int{
        return $this->idEmpresa;
    }

    public function save(): bool 
    {
        $connection = new MySQL();
        
        if (isset($this->idDocumento)) {
            $sql = "UPDATE documento SET nome = '{$this->nome}', validade = '{$this->validade->format('Y-m-d H:i:s')}', pdf = '{$this->pdf}' WHERE idDocumento = {$this->idDocumento}";
        }
        else {
            $sql = "INSERT INTO documento (nome,validade,pdf,idEmpresa) VALUES ('{$this->nome}','{$this->validade->format('Y-m-d H:i:s')}','{$this->pdf}','{$this->idEmpresa}')";
        }
        
        return $connection->execute($sql);
    }

    public function delete(): bool
    {
        $connection = new MySQL();
        $sql = "DELETE FROM documento WHERE idDocumento = {$this->idDocumento}";
        return $connection->execute($sql);
    }

    public static function find($id): Documento
    {
        $connection = new MySQL();
        $sql = "SELECT * FROM documento WHERE idDocumento = {$id}";
        $res = $connection->query($sql);
        if (!$res) {
            return null;
        }
        $documento = new Documento;
        $documento->constructorCreate(
            $res[0]['nome'],
            new DateTime($res[0]['validade']),
            $res[0]['pdf']
        );
        $documento->setIdDocumento($res[0]['idDocumento']);
        $documento->setIdEmpresa($res[0]['idEmpresa']);
        
        return $documento;
    }

    public static function findall():array{
        $connection = new MySQL();
        $sql = "SELECT * FROM documento";
        $results = $connection->query($sql);
        $documentos = array();
        foreach($results as $res){
            $d = new Documento;
            $d->constructorCreate(
                $res['nome'],
                new DateTime($res['validade']),
                $res['pdf']
            );
            $d->setIdDocumento($res['idDocumento']);
            $d->setIdEmpresa($res['idEmpresa']);
            $documentos[] = $d;
        }
        return $documentos;
    }

    public static function findallByDocumento($idEmpresa):array{
        $connection = new MySQL();
        $sql = "SELECT * FROM documento WHERE idEmpresa = {$idEmpresa}";
        $resultados = $connection->query($sql);
        $documentos = array();
        foreach($resultados as $resultado){
            $d = new Documento;
            $d->constructorCreate(
                $resultado['nome'],
                new DateTime($resultado['validade']),
                $resultado['pdf']
            );
            $d->setIdDocumento($resultado['idDocumento']);
            $d->setIdEmpresa($resultado['idEmpresa']);
            $documentos[] = $d;

        }
        return $documentos;
    }
    

}