<?php

class CpSpecialOffer extends CComponent
{
    public function init() { }


    /**
     * Search offers by params
     * 
     * @param array $params
     * @return array list of offers
     */
    public function search($params)
    {
        $queryParams = array(
                ':now_date'=> date('Y-m-d H:i:s'),
                ':latRadian'=>$params['lat'] * 0.0175,
                ':lonRadian'=>$params['lon'] * 0.0175,
                ':radius'=>$params['radius']
        );

        $query = Yii::app()->db->createCommand()
            ->select("
                spo.id id, spo.title title, spo.body body, 
                spo.start_date start_date, spo.end_date end_date, spo.campaign_id campaign_id,

                (acos(sin( :latRadian ) * sin(aroundme.lat * 0.0175) + cos( :latRadian ) * cos(aroundme.lat * 0.0175) * cos(aroundme.lon * 0.0175 - ( :lonRadian ))) * 6371000) AS distance,
                lat, lon

            ")
            ->from('special_offer spo')

            ->leftJoin('campaign', 'spo.campaign_id = campaign.id')
            ->leftJoin('campaign2aroundme c2a', 'c2a.campaign_id = campaign.id')
            // selected aroundme or all for branches_type=all in campaign
            ->join(
                    'aroundme',
                    'c2a.aroundme_id = aroundme.id or
                        (campaign.branches_type = 0 and campaign.company_id = aroundme.company_id)'
             )

            // for active companies
            ->andWhere('campaign.type = 1')
            ->andWhere('(acos(sin( :latRadian ) * sin(aroundme.lat * 0.0175) + cos( :latRadian ) * cos(aroundme.lat * 0.0175) * cos(aroundme.lon * 0.0175 - ( :lonRadian ))) * 6371000) <= :radius')
            ->andWhere('spo.start_date < :now_date and spo.end_date > :now_date')
            ->andWhere('campaign.start_date < :now_date and campaign.end_date > :now_date')

            ->group('id');

        $count = $query->queryScalar($queryParams);

        $query->offset($params['offset'])
                ->limit($params['rows'])
                ->order('distance');

                
        $offers = $query->queryAll(true, $queryParams);

        $result = array(
            'total' => (int)$count,
            'offers' => array(),
        );
        foreach ($offers as $offer) {
            $result['offers'][] = Yii::app()->offer->getServiceOfferData((object)$offer);
        }
        
        return $result;
    }

    /**
     * Format offer data for mobile service
     *
     * @param SpecialOffe $offer model
     * @return array
     */
    public function getServiceOfferData($offer)
    {
        $data = array(
            'id' => (int)$offer->id,
            'title' => (string)$offer->title,
            'body' => (string)$offer->body,
            'start_date' => (string)$offer->start_date,
            'end_date' => (string)$offer->end_date,
            'lat' => (float)$offer->lat,
            'lon' => (float)$offer->lon,
            'distance' => (float)$offer->distance,
            'images' => $this->getServiceOfferImagesData($offer->id),
        );
        return $data;
    }

    protected function getServiceOfferImagesData($offerId)
    {
        $images = array();
        if ($specialOffer = SpecialOffer::model()->findByPk($offerId)) {
            foreach ($specialOffer->specialOffer2images as $specialOffer2image) {
                $images[] = array(
                    'title' => $specialOffer2image->image_title,
                    'text' => $specialOffer2image->image_text,
                    'url' => $specialOffer2image->image_url,
                    'src' => ($specialOffer2image->image ? Yii::app()->image->getServerPath($specialOffer2image->image) : ""),
                );
            }
        }
        return $images;
    }

}
