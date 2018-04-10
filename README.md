# Project 1: Collaborative news
## Group 21
## Members
 * Afonso Ramos - up201506239@fe.up.pt
 * Daniel Silva - up201503212@fe.up.pt
 * Miguel Ramalho - up201403027@fe.up.pt
 * Vítor Minhoto - up201303086@fe.up.pt

## Editor Notes
 * Check that all numeration is in ascending order
 * check that no quoted instrcutions is left on the artefact
 * check that all the urls are working
 * check the submission date
 * check the revision information

## Artefacts

 * [A7](https://hackmd.io/Hk36u2otREmVxBWReAERnA) Editor: **Miguel**
    * Status: **[not submited]**
    * Tasks [deadline 09/04/2018]
      * Afonso - Module Post (with module description); Module Flag (with module description); Module User Admin (write routes and include module description)
      * Daniel - [A6_2] ~change post frequency to hundreds per year and similar stuff; find copy past of `SELECT01`; in `SELECT02` say why no clustering (impact on updates); `SELECT 04` decide between btree (btree does need range) and hash (for high cardinality)~; submeter A6_2[A7] Module Authentication (with module description)
      * Miguel - ~[A6_2] clear SQL (remove comments, remove useless, join stuff for the same table);~ [A7] Module Users (with module description); ~Module Static Pages (with module description);~
      * Vitor - ~create table stub~; ~Module Comments (with module description)~; Module University Faculty Administration(UFA) (with module description);
   * Modules:
      * [D] M01:Authentication
      * [M] M02:User Profile
      * [A] M03:Posts
      * [V] M04:University Faculty Administration
      * [A] M05:User Administration
      * ~M06:Votes~
      * [M] M06:Static Pages
      * [V] M07:Comments
      * [A] M08:Flags
 * [A6](https://hackmd.io/JMpTEtGyTYGeBeBYbTGIZA) Editor: **Daniel**
    * [trigger slides](https://web.fe.up.pt/~arestivo/presentation/triggers/)
    * [indexes slides](https://web.fe.up.pt/~arestivo/presentation/indexes/)
    * Status: **[submited]**
    * Tasks [deadline 30/03/2018]
      * Afonso - ~[fake-data] use [mockaroo](https://www.mockaroo.com/) to generate some more fake data (not too much) for the tables (see the lines that already exist)~; ~[frequent-updates] insert query for flag_comment, flag_post, flag_user~; ~[frequent-updates] to insert a new post~; ~[trigger] to calculate the number of votes in a post, whenever a vote is cast or deleted~;
      * Daniel - ~[performance-index] for user attributes using hash (high cardinality); [performance-index] for post faculties and similar (if found) using btree (medium cardinality);~ ~[editor] put all the SQL (from the A5) together (see example); [editor] fix numeration in the A6 query names; [editor] remove comments and brush up A6 and deliver; (note from M: verificar se as colunas search_title e search_content aparecem no SQL da criação das tabelas).~    
      * Miguel - ~[full-text-search-index] for search_title and search_content (explain why GIN over GIST)~; ~[trigger] for the full text search ts_vector update~; ~[trigger] to prevent users from voting on own post~; ~[trigger] to prevent users from flagging own posts~; ~[trigger] similar for comments~; ~[trigger] to ensure that a user cannot have more than two mobilities in the same year~. 
      * Vitor - ~[frequent-updates] for flagging something: flag_comment, flag_post, flag_user~; ~[frequent-updates] to create a post (see the ones already done)~; ~[frequent-updates] to update post (easy after insert)~; ~[frequent-updates] for archiving flags (flag_comment, flag_post, flag_user)~; ~[frequent-updates] to delete a comment~; 
      * Grupo - ver se falta alguma das 4 coisas (frequent queries, frequent updates, proposed indices, triggers); [optional-trigger] to calculate statistics based on beer_cost, life_cost, etc.
 

 * [A5](https://hackmd.io/uB1_EPPXQlGHMfLwJFJYMw) Editor: **Afonso**
    * Status: **[submited]**
      
  * [A4](https://hackmd.io/DnNwGsCNQtK48EZJJBi1Pw) Editor: **Vitor**
    * Status: **[submited]**
    * [Database table with countries](https://github.com/raramuridesign/mysql-country-list/blob/master/mysql-country-list.sql)
    * Tasks [deadline 13/03/2018]
      * Afonso -
      * Daniel - ~converter para enterprise architect~
      * Miguel -  
      * Vitor - ~escrever texto e colocar imagem do daniel~
      
  * [A3](https://hackmd.io/CwRgrAHAbATAZhAtAYxgEzo4yIAZF4CGAzIiAJxRyECm5ENuhaQA) Editor: **Miguel**
    * Status: **[submited]**
    * [GHPages](https://msramalho.github.io/lbaw1721/)
    * [Dwaw.io - SiteMap](https://drive.google.com/file/d/1W-SPXbB57z5ZN7S4vmGSInLCbPAg0bjc/view?usp=sharing)
    * Tasks [deadline 01/03/2018]
      * Afonso - ~Ver a cor~; ~Design do Logo~; ~statistics~; ~FAQ (bootstrap Accordion)~; ~about~ ; ~recover password~
      * Daniel - ~Footer~; ~feed (search, list of posts)~; ~post page~
      * Miguel - ~Navbars (unauthenticated, authenticated, admin)~; ~new post~; ~contacts~
      * Vitor - ~sitemap~; ~User Profile (details, following, history)~;
    * Tasks [deadline 06/03/2018 - 19h]
      * Afonso - ~Statistics bonitas~ ; ~Wireflows~; ~insert photos in report~; ~Finishing Touches~; 
      * Daniel - ~Search~; ~Manage Flags~; ~Manage Users~;
      * Miguel - ~Edit Post~; ~Manage Universities~; ~Manage Faculties~
      * Vitor - ~Edit User~; ~put flag in user profile~; 
    * Tasks [deadline 13/03/2018]
      * Afonso - ~mais destaque user profile navegação (cor mais forte)~; ~Dar destaque ao sign-in, mudar nome e ou cor~; ~Fix Buttons Colours~;
      * Daniel - ~View post, meter os 3 labels para cima da imagem~; ~10-12 palavras para o texto (diminuir largura)~; ~aumentar tamanho de letra dos post previews nos feeds~. ~tirar classes não usadas do user.management~
      * Miguel - ~Frola editor, meter maior altura;~ converter markdown em pdf com links (tentar `[link](url)`)
      * Vitor - ~caixa da foto mais pequena~; ~meter 1 form element por linha~; ~aumentar tamanho de texto dos following~; ~date->birthdate~; ~tirar gender~;
      
 * [A2](https://hackmd.io/EwZgHGBmBsCmAmBaaAGaBDRAWLrECMBjAdn0XjC2IE551hQBWQoA) Editor: **Daniel** [example](https://web.fe.up.pt/~jlopes/doku.php/teach/lbaw/medialib/a2)
   * Status: **[submited]**
   * [Draw.io - UML](https://drive.google.com/file/d/1jJV-MGkb27NeJCkNnhLYBqZ4u2EGb1-L/view?usp=sharing)
   * Tasks [deadline 19/02/2018]:
     * Afonso - ~User Stories~
     * Daniel - ~User Stories~
     * Miguel - ~Supplementary requirements~
     * Vitor - ~Actors (UML + Table)~

 * [A1](https://hackmd.io/KwZmCYCNIU3BaAhuAxseAWDAOA7PATlwAZjMBGAE2xEgDNKCnIg=) Editor: **Afonso**
   * Status: **[submited]**
