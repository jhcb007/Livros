<?php

namespace AntoineAugusti\Books;

use DateTime;
use GuzzleHttp\ClientInterface;
use InvalidArgumentException;

class Fetcher
{
    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Retrieve information about a book given its ISBN.
     *
     * @param string $texto
     *
     * @throws InvalidArgumentException When the ISBN has not the expected format
     * @throws InvalidResponseException When the client got an unexpected response
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function pesquisa_all($texto)
    {
        $response = $this->client->request('GET', 'volumes', [
            'query' => ['hl' => 'pt-br', 'q' => $texto, 'maxResults' => 20, 'orderBy' => 'relevance', 'fields' => 'totalItems,items(accessInfo,volumeInfo(title))'],
            'http_errors' => false,
        ]);

        $status = $response->getStatusCode();
        if ($status != 200) {
            throw new InvalidResponseException('Invalid response. Status: ' . $status . '. Body: ' . $response->getBody());
        }

        return $response->getBody();
    }

    /*
     * https://developers.google.com/books/docs/v1/using#st_params
     * https://github.com/pashacraydon/backbone-books
     *  self = this,
          $books = $('#books'),
          url = 'https://www.googleapis.com/books/v1/volumes?',
          data = 'q='+encodeURIComponent(term)+'&startIndex='+index+'&maxResults='+maxResults+'&key='+v.API_KEY+'&projection=full&fields=totalItems,items(id,volumeInfo)',
          moreBtn = '<button data-index="'+index+'" data-term="'+term+'" data-maxresults="'+maxResults+'" class="btn more-button" href="#">&#43; More of these books</button>',
          dupBtn = moreBtn.length,
          books = new BookCollection();
    ---------------------------------------

    var $searchForm = $('#search_input'),
        term = $searchForm.val(),
        self = this,
        url = 'https://www.googleapis.com/books/v1/volumes?q='+encodeURIComponent(term)+'&maxResults=8&key='+v.API_KEY+'&fields=totalItems,items(accessInfo,volumeInfo)';
     */
}
