<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Wavey\Sweetalert\Sweetalert;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresaId = session('empresa_id');

        if (!$empresaId)
        {
            $empresaId = Auth::user()->empresa_id;
        }
        
        try {
            $produtos = Produto::where('empresa_id', $empresaId)->get();
            return view('produto.all', ['produtos' => $produtos]);
            
        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $empresas = Empresa::where('id', session('empresa_id'))->get();
            return view('produto.form', ['empresas' => $empresas]);

        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'descricao' => 'required|string|max:255',
                'precocusto' => 'required|numeric',
                'precovenda' => 'required|numeric',
                'estoque' => 'required|integer',
                'empresa_id' => 'required|exists:empresas,id',
            ], [
                'descricao.required' => 'A descrição é obrigatória.',
                'descricao.max' => 'A descrição pode ter no máximo 255 caracteres.',
                'precocusto.required' => 'O preço de custo é obrigatório.',
                'precocusto.numeric' => 'O preço de custo deve ser numérico.',
                'precovenda.required' => 'O preço de venda é obrigatório.',
                'precovenda.numeric' => 'O preço de venda deve ser numérico.',
                'estoque.required' => 'O estoque é obrigatório.',
                'estoque.integer' => 'O estoque deve ser um número inteiro.',
                'empresa_id.required' => 'Selecione a empresa.',
                'empresa_id.exists' => 'A empresa selecionada é inválida.',
            ]);
    
            Produto::create($validatedData);
            Sweetalert::success('Produto criado com sucesso!', 'Sucesso');
            return redirect()->route('produtos.index')->with('success', 'Produto criado com sucesso!');
            
        } catch (\Exception $e) {
            Sweetalert::error('Erro ao inserir produto !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produto $produto)
    {
        // return view('produtos.show', compact('produto'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produto $produto)
    {
        try {
            $empresas = Empresa::where('id', session('empresa_id'))->get();
            return view('produto.form', compact('produto', 'empresas'));

        } catch (\Exception $e) {
            Sweetalert::error('Verifique se selecionou a empresa !'.$e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produto $produto)
    {
        try {
            $validatedData = $request->validate([
                'descricao' => 'required|string|max:255',
                'precocusto' => 'required|numeric',
                'precovenda' => 'required|numeric',
                'estoque' => 'required|integer',
                'empresa_id' => 'required|exists:empresas,id',
            ], [
                'descricao.required' => 'A descrição é obrigatória.',
                'descricao.max' => 'A descrição pode ter no máximo 255 caracteres.',
                'precocusto.required' => 'O preço de custo é obrigatório.',
                'precocusto.numeric' => 'O preço de custo deve ser numérico.',
                'precovenda.required' => 'O preço de venda é obrigatório.',
                'precovenda.numeric' => 'O preço de venda deve ser numérico.',
                'estoque.required' => 'O estoque é obrigatório.',
                'estoque.integer' => 'O estoque deve ser um número inteiro.',
                'empresa_id.required' => 'Selecione a empresa.',
                'empresa_id.exists' => 'A empresa selecionada é inválida.',
            ]);
    
            $produto->update($validatedData);
            Sweetalert::success('Produto atualizado com sucesso!', 'Sucesso');
            return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao atualizar produto !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produto $produto)
    {
        try {
            $produto->delete();
            Sweetalert::success('Produto excluido com sucesso!', 'Sucesso');
            return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso!');

        } catch (\Exception $e) {
            Sweetalert::error('Erro ao atualizar produto !'.$e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Normaliza valores numéricos (troca vírgula por ponto, remove milhar, etc.).
     */
    private function toFloat($value): float
    {
        if ($value === null) return 0.0;
        $v = (string)$value;
        // remove espaços, prefixos de moeda e separadores de milhar
        $v = trim(str_replace([' ', 'R$', 'r$', "\xc2\xa0"], '', $v));
        $v = str_replace(['.', ';'], ['', ''], $v); // remove . e ; como milhar
        $v = str_replace(',', '.', $v);             // vírgula para ponto
        return is_numeric($v) ? (float)$v : 0.0;
    }

    /**
     * Limpa/valida código de barras (remove não dígitos, ignora 'SEM GTIN').
     */
    private function sanitizeBarcode(?string $ean): ?string
    {
        if ($ean === null) return null;
        $t = strtoupper(trim($ean));
        if ($t === '' || $t === 'SEM GTIN' || $t === 'SEMGTIN' || $t === '0') return null;
        $digits = preg_replace('/\D+/', '', $t);
        return $digits !== '' ? $digits : null;
    }

    /**
     * Detecta o delimitador do CSV (vírgula, ponto e vírgula ou tab).
     */
    private function detectCsvDelimiter(string $filePath): string
    {
        $line = '';
        $fh = fopen($filePath, 'r');
        if ($fh !== false) {
            $line = fgets($fh, 4096) ?: '';
            fclose($fh);
        }
        $candidates = [',' => substr_count($line, ','), ';' => substr_count($line, ';'), "\t" => substr_count($line, "\t")];
        arsort($candidates);
        return (string) array_key_first($candidates);
    }

    /**
     * Remove BOM UTF-8 do primeiro campo do cabeçalho se existir.
     */
    private function stripBom(string $text): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $text) ?? $text;
    }

    /**
     * Import products from a CSV file.
     */
    public function importCsv(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:csv,txt|max:2048',
            ], [
                'file.required' => 'Envie um arquivo CSV.',
                'file.mimes' => 'O arquivo deve ser do tipo CSV (.csv).',
                'file.max' => 'O arquivo CSV deve ter no máximo 2 MB.',
            ]);

            $empresaId = session('empresa_id') ?? Auth::user()->empresa_id;

            if (!$empresaId) {
                Sweetalert::error('Nenhuma empresa selecionada!', 'Erro');
                return redirect()->back();
            }

            $path = $request->file('file')->getRealPath();
            $delimiter = $this->detectCsvDelimiter($path);
            $imported = 0;

            DB::transaction(function () use ($path, $delimiter, $empresaId, &$imported) {
                if (($handle = fopen($path, 'r')) !== false) {
                    // Cabeçalho
                    $header = fgetcsv($handle, 0, $delimiter);
                    if (!$header) {
                        throw new \RuntimeException('Cabeçalho CSV ausente ou inválido.');
                    }
                    // Normaliza cabeçalhos: remove BOM e força minúsculo
                    $header = array_map(function ($h) {
                        $h = $this->stripBom((string)$h);
                        return strtolower(trim($h));
                    }, $header);

                    while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                        if (count($row) === 1 && trim(implode('', $row)) === '') {
                            continue; // linha em branco
                        }
                        $data = @array_combine($header, $row);
                        if (!$data) continue;

                        $descricao   = $data['descricao']   ?? '';
                        $precocusto  = $this->toFloat($data['precocusto'] ?? null);
                        $precovenda  = $this->toFloat($data['precovenda'] ?? null);
                        $estoque     = isset($data['estoque']) ? (int)$this->toFloat($data['estoque']) : 0;
                        $codbarra    = $this->sanitizeBarcode($data['codbarra'] ?? null);
                        $unidade     = $data['unidade'] ?? '';
                        $ncm         = $data['ncm'] ?? null;
                        $cst         = $data['cst'] ?? null;
                        $cfop        = $data['cfop'] ?? null;

                        Produto::updateOrCreate(
                            [
                                'empresa_id' => $empresaId,
                                'codbarra'   => $codbarra,
                            ],
                            [
                                'descricao'  => $descricao,
                                'precocusto' => $precocusto,
                                'precovenda' => $precovenda,
                                'estoque'    => $estoque,
                                'unidade'    => $unidade,
                                'ncm'        => $ncm,
                                'cst'        => $cst,
                                'cfop'       => $cfop,
                            ]
                        );
                        $imported++;
                    }
                    fclose($handle);
                }
            });

            Sweetalert::success("Importação CSV concluída! Registros processados: {$imported}", 'Sucesso');
            return redirect()->route('produtos.index');
        } catch (\Throwable $e) {
            Sweetalert::error('Erro ao importar produtos CSV: ' . $e->getMessage(), 'Erro');
            return redirect()->back();
        }
    }

    /**
     * Download a CSV template.
     */
    public function csvTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="produtos_template.csv"',
        ];

        $columns = ['descricao', 'precocusto', 'precovenda', 'estoque', 'codbarra', 'unidade', 'ncm', 'cst', 'cfop'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import products from an XML file.
     */
    public function importXml(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xml|max:2048',
            ], [
                'file.required' => 'Envie um arquivo XML.',
                'file.mimes' => 'O arquivo deve ser do tipo XML (.xml).',
                'file.max' => 'O arquivo XML deve ter no máximo 2 MB.',
            ]);

            $empresaId = session('empresa_id') ?? Auth::user()->empresa_id;

            if (!$empresaId) {
                Sweetalert::error('Nenhuma empresa selecionada!', 'Erro');
                return redirect()->back();
            }

            $xml = simplexml_load_file($request->file('file')->getRealPath());
            if (!$xml) {
                Sweetalert::error('XML inválido!', 'Erro');
                return redirect()->back();
            }

            $imported = 0;

            DB::transaction(function () use ($xml, $empresaId, &$imported) {
                // Tenta com namespace padrão da NF-e
                $ns = $xml->getNamespaces(true);
                $detNodes = [];

                if (isset($ns['']) || isset($ns['nfe'])) {
                    // registra ambos: vazio e 'nfe'
                    $dom = new \SimpleXMLElement($xml->asXML());
                    foreach ($ns as $prefix => $uri) {
                        $dom->registerXPathNamespace($prefix ?: 'nfe', $uri);
                    }
                    $detNodes = $dom->xpath('//nfe:det');
                }

                // Fallback sem namespace
                if (!$detNodes || count($detNodes) === 0) {
                    $detNodes = $xml->xpath('//det');
                }

                foreach ($detNodes as $item) {
                    // Garante acesso ao nó prod considerando namespace
                    $prod = isset($item->prod) ? $item->prod : (isset($item->children()->prod) ? $item->children()->prod : null);
                    if (!$prod) {
                        // tenta via children de todos namespaces
                        foreach ($item->children() as $child) {
                            if ($child->getName() === 'prod') { $prod = $child; break; }
                        }
                    }
                    if (!$prod) continue;

                    $cEAN      = (string)($prod->cEAN ?? $prod->cEANTrib ?? '');
                    $codbarra  = $this->sanitizeBarcode($cEAN);
                    $descricao = (string)($prod->xProd ?? '');
                    $vUn       = (string)($prod->vUnCom ?? $prod->vUnTrib ?? '0');
                    $qCom      = (string)($prod->qCom ?? '0');
                    $uCom      = (string)($prod->uCom ?? $prod->uTrib ?? '');
                    $ncm       = (string)($prod->NCM ?? '');
                    $cfop      = (string)($prod->CFOP ?? '');

                    Produto::updateOrCreate(
                        [
                            'empresa_id' => $empresaId,
                            'codbarra'   => $codbarra,
                        ],
                        [
                            'descricao'  => $descricao,
                            'precocusto' => $this->toFloat($vUn),
                            'precovenda' => $this->toFloat($vUn),
                            'estoque'    => (int)$this->toFloat($qCom),
                            'unidade'    => $uCom,
                            'ncm'        => $ncm !== '' ? $ncm : null,
                            'cst'        => null,
                            'cfop'       => $cfop !== '' ? $cfop : null,
                        ]
                    );
                    $imported++;
                }
            });

            Sweetalert::success("Importação XML concluída! Itens processados: {$imported}", 'Sucesso');
            return redirect()->route('produtos.index');
        } catch (\Throwable $e) {
            Sweetalert::error('Erro ao importar produtos XML: ' . $e->getMessage(), 'Erro');
            return redirect()->back();
        }
    }
}
