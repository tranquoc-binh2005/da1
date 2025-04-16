<?php
namespace App\Http\Repositories\Product;

use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\Interfaces\ProductVariantRepositoryInterface;
use App\Models\Database;
use App\Models\ProductVariant;
use PDO;

class ProductVariantRepository extends BaseRepository implements ProductVariantRepositoryInterface
{
    protected PDO $database;
    protected ProductVariant $model;
    public function __construct()
    {
        $this->database = Database::connection();
        $this->model = new ProductVariant();
        parent::__construct($this->model);
    }

    /**
     * @throws \Exception
     */
    public function saveVariant(?int $productId = null, array $payloadVariant = [])
    {
        try {
            if (empty($productId)) {
                echo "Product ID is required"; die();
            }

            $variants = $this->prepareDataProductVariant($productId, $payloadVariant);

            foreach ($variants as $value) {
                if (empty($value['product_id']) || empty($value['unit_id']) || empty($value['sku'])) {
                    echo "Dữ liệu không hợp lệ: product_id, unit_id, sku không được để trống."; die();
                }

                if (!empty($value['variant_id'])) {
                    $this->updateVariant($value);
                } else {
                    $this->insertVariant($value);
                }
            }
            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function insertVariant(array $value): void
    {
        try {
            $sql = "INSERT INTO {$this->model->getTable()} 
            (product_id, unit_id, sku, price, stock) 
            VALUES (:product_id, :unit_id, :sku, :price, :stock)";

            $params = [
                ':product_id' => $value['product_id'],
                ':unit_id' => $value['unit_id'],
                ':sku' => $value['sku'],
                ':price' => $value['price'],
                ':stock' => $value['stock'],
            ];

            $this->insert($sql, $params);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function updateVariant(array $value): void
    {
        try {
            $sql = "UPDATE {$this->model->getTable()} 
            SET product_id = :product_id, 
                unit_id = :unit_id, 
                sku = :sku, 
                price = :price, 
                stock = :stock
            WHERE id = :variant_id";

            $params = [
                ':variant_id' => $value['variant_id'],
                ':product_id' => $value['product_id'],
                ':unit_id' => $value['unit_id'],
                ':sku' => $value['sku'],
                ':price' => $value['price'],
                ':stock' => $value['stock'],
            ];

            $this->execute($sql, $params);
        } catch (\Exception $e) {
            throw $e;
        }
    }


    /**
     * @throws \Exception
     */
    private function deleteOldVariants(int $productId): void
    {
        $sql = "DELETE FROM {$this->model->getTable()} WHERE product_id = :product_id";
        $this->execute($sql, [':product_id' => $productId]);
    }


    /**
     * @throws \Exception
     */
    private function prepareDataProductVariant(int $productId, array $data): array
    {
        if (empty($data['price'])) {
            return [];
        }

        $mergedData = [];
        foreach ($data['price'] as $key => $value) {
            $mergedData[] = [
                'product_id' => (int)$productId,
                'price' => $value,
                'unit_id' => (int)$data['unit_id'][$key] ?? null,
                'variant_id' => isset($data['variant_id'][$key]) ? (int)$data['variant_id'][$key] : null,
                'sku' => $data['sku'][$key] ?? null,
                'stock' => (int)$data['stock'][$key] ?? null,
            ];
        }
        return $mergedData;
    }

    public function findByProductId(int $productId): array
    {
        try {
            $sql = "SELECT 
                    tb1.*, 
                    tb2.value AS unit_value, 
                    tb2.unit AS unit_name
                FROM {$this->model->getTable()} AS tb1
                LEFT JOIN unit_products AS tb2 ON tb1.unit_id = tb2.id
                WHERE tb1.product_id = :product_id";

            return $this->get($sql, [":product_id" => $productId]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function updateQuantiyAndSold(array $data): int
    {
        try {
            $sql = "UPDATE {$this->model->getTable()}
                    SET stock = stock - :qty, 
                        sold = sold + :qty
                    WHERE id = :product_variant_id";
            $params = [
                ':qty' => $data['quantity'],
                ':product_variant_id' => $data['product_variant_id'],
            ];
            return $this->execute($sql, $params);
        } catch (\Exception $e){
            throw $e;
        }
    }

    public function productBestSelling(): array
    {
        try {
            $sql = "SELECT product_id, SUM(sold) as total_sold, tb2.*, tb3.name as product_catalogue_name, tb4.name as product_brand_name
                    FROM product_variants AS tb1
                    JOIN products AS tb2 ON tb1.product_id = tb2.id
                    JOIN product_catalogues AS tb3 ON tb2.product_catalogue_id = tb3.id
                    JOIN brand_products AS tb4 ON tb2.brand_product_id = tb4.id
                    GROUP BY product_id
                    ORDER BY total_sold DESC LIMIT 10";
            return $this->get($sql);
        } catch (\Exception $e){
            throw $e;
        }
    }

}