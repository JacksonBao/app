<?php
namespace Traits;

Trait NotificationTemplateTraits{

    public $noteDefaultImage = '/public/img/app/logo.png';

    public function noteInView(array $data)
    {
        if(in_array($data['type'], $this->transactionTypes)){
            $data['link'] = WALLET_SITE_URL . '/transactions/view/' . $data['item'];
        }

        $link = $data['link'];
        if($link != false){
            $link = '
            <a href="'.$data['link'].'" class="btn btn-sm btn-third float-right">
            View
            </a>
            ';
        } else {
            $link = '';
        } 

        $template = '
        <div class="card  mb-3 w3-border-0 w3-leftbar border-third ">
            <div class="media p-3">
                <img src="'.($data['image'] ?: $this->noteDefaultImage).'" style="height: 45px;" class="mr-2">
                <div class="media-body">
                '.$link.'
                    <b class="m-0">'.$data['name'].'</b>
                    <small>'.$data['message'].' </small><br>
                    
                    <small class="w3-text-grey">'.$this->timeAgo($data['created_at']).'</small>
                </div>
            </div>
        </div>
    ';

    return $template;
    }
    public function listTemplate(array $data)
    {
                     if(in_array($data['type'], $this->transactionTypes)){
                         $data['link'] = WALLET_SITE_URL . '/transactions/view/' . $data['item'];
                     }
        $template = '
            <li class="">
                <div class="media">
                    <img src="'.($data['image'] ?: $this->noteDefaultImage).'" style="height: 35px;" class="mr-2">
                    <div class="media-body text_12">
                    <a href="notifications/view/'.$data['id'].'">
                        <b class="m-0">'.$data['name'].'</b>
                        <small>'.$data['message'].'</small></a> <small><a href="'.$data['link'].'"> View </a> </small><br>
                        <small class="w3-text-grey">'.$this->timeAgo($data['created_at']).'</small>
                    </div>
                </div>
            </li>
        ';
        
        return $template;   
    }
    /**
     * @param
     */
    public function defaultTemplate(array $data) // extra fields = [link, image]
    {            
        if(in_array($data['type'], $this->transactionTypes)){
            $data['link'] = WALLET_SITE_URL . '/transactions/view/' . $data['item'];
        }
        $template = '
            <div class="card  mb-3">
                <div class="media p-3">
                    <img src="'.($data['image'] ?: $this->noteDefaultImage).'" style="height: 45px;" class="mr-2">
                    <div class="media-body">
                        <a href="'.$data['link'].'">
                        <b class="m-0">'.$data['name'].'</b>
                        <small>'.$data['message'].' </small><br>
                        </a>
                        <small class="w3-text-grey">'.$this->timeAgo($data['created_at']).'</small>
                    </div>
                </div>
            </div>
        ';
        
        return $template;
    }

    /**
     * @param 
     */
    public function tableRow(array $data) //  
    {        

        if(in_array($data['type'], $this->transactionTypes)){
            $data['link'] = WALLET_SITE_URL . '/transactions/view/' . $data['item'];
        }
        $template = '
        <tr>
            <th>1</th>
            <td>
            <div class="media">
                <img src="'.($data['image'] ?: $this->noteDefaultImage).'" style="height: 45px;" class="mr-2">
                <div class="media-body">
                    <b class="m-0 text-dark">'.$data['name'].'</b>
                    <small>'.$data['message'].'</small><br>
                    <small class="w3-text-grey">'.$this->timeAgo($data['created_at']).'</small>
                </div>
            </div>
            </td>
            <td>
                <a href="'.$data['link'].'" class="btn btn-third">View</a>
            </td>

            </tr>
            ';
            return $template;
    }

}
