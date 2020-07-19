<?php

namespace frontend\forms;

use Yii;
use yii\base\Model;
use common\entities\Rent;
use common\entities\Tariffs;

class RentForm extends Model
{
    public $user_id;
    public $product_id;
    public $tariff_id;

    public function rules()
    {
        return [
            ['tariff_id', 'required'],
            [['user_id', 'product_id', 'tariff_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tariff_id' => Yii::t('app', 'Длительность аренды'),
        ];
    }

    public function create()
    {
        $rent = new Rent();

        $rent->status = 0;
        $rent->user_id = $this->user_id;
        $rent->product_id = $this->product_id;
        $rent->tariff_id = $this->tariff_id;
        $rent->per_month = Tariffs::findOne($this->tariff_id)->price_per_month;

        $rent->save();

        return $rent;
    }

    public function mail($rent)
    {
        $this->sendToAdmin($rent);
    }

    private $adminHtml;

    public function sendToAdmin($rent)
    {
        /* @var $rent Rent */

        $this->adminHtml .= "<style>";
        $this->adminHtml .= ".h2{ font-size:2em; font-weight:lighter; text-transform:uppercase;}";
        $this->adminHtml .= "img{ width:200px;}";
        $this->adminHtml .= "</style>";
        $this->adminHtml .= "<table>";
        $this->adminHtml .= "<tr><td colspan='2' class='form-heading' ><h2>Клиент</h2></td><td></td></tr>";
        $this->adminHtml .= "<tr><td>Имя</td><td>: {$rent->user->username}</td></tr>";
        $this->adminHtml .= "<tr><td>Телефон</td><td>: {$rent->user->phone}</td></tr>";
        $this->adminHtml .= "<tr><td>E-mail</td><td>: {$rent->user->email}</td></tr>";
        $this->adminHtml .= "<tr><td colspan='2' class='form-heading' ><h2>Арендовал картину</h2></td><td></td></tr>";
        $this->adminHtml .= "<tr><td>Название</td><td>: {$rent->product->title_ru}</td></tr>";
        $this->adminHtml .= "<tr><td>Период</td><td>: {$rent->tariff->period}</td></tr>";
        $this->adminHtml .= "<tr><td>Стоимость</td><td>: {$rent->tariff->price}</td></tr>";
        $this->adminHtml .= "</table>";

        $sent = Yii::$app->mailer->compose()
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setTo(Yii::$app->params['adminEmail'])
            ->setSubject('Пользователь ' . $rent->user->username . ' арендовал картину')
            ->setHtmlBody($this->adminHtml)
            ->send();

        if (!$sent) {
            throw new \RuntimeException('Ошибка отправки E-mail.');
        }
    }
}
