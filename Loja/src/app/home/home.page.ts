import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {
  private url:string="http://localhost/dbloja/data/produto/listar.php";
 
  /*
  Vamos receber os produtos cadastrados na forma de json da API por meio da url acima.
  O conteudo que virá será uma lista de objetos, ou seja, uma lista de produtos.
  Para utilizar essa lista na pagina principal(home.html) estamos usando um  Array
  de objetos que receberá os dados da API e irá repassar para o nosso laço(*ngfor) 
  na home.
  */
 public produtos:Array<object>=[];
  constructor(private http:HttpClient) {}
  /* O comanod ngOnInit(ng->todos os comando internos do angular| On->Ativar, ligar|
     Init-> Initialize = iniciar)
    No momento em que a página home inicializa será feita uma requisição http
     dentro do método ngOnInit para buscar os produtos cadastrados 
    O comando ngOnInit é iniciado automáticamente, 
    portanto não é necessario chamar. 
    */
  ngOnInit(){
    /*
    Os comandos:
    this -> refere-se a essa classe homePage e todo seu conteúdo;
    http-> é um elemento tipado como HttpClient responsável por fazer
    as requisições do REST com os verbos: get, post, put e delete. Esse 
    elemento foi declarado no contrutor da classe. Construtor é reponsavel 
    por iniciar a classe com seu conteudo;
    get-> significa obter é responsavel por chamar o conteúdo da pagina listar com todos os seus produtos. 
    -----------------------------------------------------------------------------------------------------------
    O comando get requisita a url para fazer chamada dos dados do produtos, por isso é passado entre parênteses a 
    url criada no contexto da classe e chamada com o comando this.url.
    O comando subcribe(Observable) é responsavel por recepcionar os dados vindos da url listar produtos com todos os seus 
    produtos. Estes são repassados para objeto data e seu conteúdo é tratado de forma genérica com o comando (data as any)
    e atribuido a constante prod.
    Com todos os produtos na constante prod, fazemos a exibição deste na tela de console.
    Mais abaixo, o comando error trata os eventuais erros ocorridos durante a requisição da API
    */
    this.http.get(this.url).subscribe(
    data=>{
      const prod = (data as any);
     this.produtos=prod.saida;
    }, error=>{
      console.log("Erro ao pesquisar a API "+error);
    }      
    )
  }
}
