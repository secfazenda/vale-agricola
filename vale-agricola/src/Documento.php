<?php

class Documento implements ActiveRecord
{
    use DateTime;
    private int $idDocumento;
    private string $nome;
    private DateTime $validade;
    private ?string $pdf;
    
    public function __construct() {}
        
    public function constructorCreate(
        string $nome,
        DateTime $validade,
        ?string $pdf
    ): void{
        $this->setNome($nome);
        $this->setValidade($validade);
        $this->setPdf($pdf);
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

    public function setValidade($validade): void{
        $this->validade = $validade;
    }

    public function getValidade(): DateTime{
        return $this->validade;
    }

    public function setPdf(?string $pdf): void{
        $this->pdf = $pdf;
    }

    public function getPdf(): ?string{
        return $this->pdf;
    }

    public function save(): bool 
    {
        $connection = new MySQL();
        
        if (isset($this->idDocumento)) {
          $sql = "UPDATE documento SET nome = '{$this->nome}', validade = '{$this->validade}', pdf = '{$this->pdf}'   WHERE idDocumento = {$this->idDocumento}";
        }

        else {
            $sql = "INSERT INTO documento (nome,validade,pdf) VALUES ('{$this->nome}','{$this->validade}','{$this->pdf}','{$this->cnpj}')";
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
        $sql = "SELECT * FROM documento WHERE documento = {$id}";
        $res = $connection->query($sql);
        $documento = new Documento;
        $documento->constructorCreate(
            $res[0]['nome'],
            $res[0]['validade'],
            $res[0]['pdf']
        );
        $documento->setIdDocumento($res[0]['idDocumento']);
        
        return $documento;
    }

    public static function findall():array{
        $connection = new MySQL();
        $sql = "SELECT * FROM documento";
        $results = $connection->query($sql);
        $documentos = array();
        foreach($results as $res){
            $d = new Documento;
            // $d = new Documento($resultado['nome'],$resultado['validade'],$resultado['pdf']);
            $d->constructorCreate(
                $res['nome'],
                $res['validade'],
                $res['pdf']
            );
            $d->setIdDocumento($res['idDocumentos']);
            $documentos[] = $d;
        }
        return $documentos;
    }

}