<?php
/**
 * Created by PhpStorm.
 * User: anatoliypopov
 * Date: 15.12.15
 * Time: 12:57
 */

namespace common\components\MyExtensions;


use common\models\Coin;
use common\models\FreeTalk;
use common\models\FreeTalkMessage;
use common\models\Hashtag;
use common\models\Message;
use common\models\PrivateMessage;
use common\models\PrivateTalk;
use common\models\Talk;
use common\models\User;
use common\models\ApiToken;
use common\models\UserTask;
use console\models\ErmioniNotification;
use filsh\yii2\gearman\JobWorkload;
use Ramsey\Uuid\Uuid;
use yii\redis\Connection;
use yii\db\Expression;

class MyNotifications
{


    const TYPE_JOIN_TALK = 1001;
    const TYPE_LEAVE_TALK = 1002;
    const TYPE_UNSUBSCRIBE_TALK = 1003;


    public static function UserRequestFreeTalk($user,$request_uuid,$apiToken){


        $joparams = array(
            'apiToken'=>$apiToken,
            'request_uuid'=>$request_uuid,
            'user'=>$user->id,
        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('requestFreeTalk', $job);
        }
        catch(\Exception $e){

        }
        
        
    
    }
    

    /**
     * @param FreeTalk $free_talk
     * @param User $users
     * @param ApiToken $apiToken
     */
    
    public static function FreeTalkRequestDone($free_talk,$user,$apiToken){
        
    }



    /**
     * @param User $user
     * @param User $follower
     * @param ApiToken $apiToken
     */
    public static function userStartFollow($user,$follower,$apiToken){


        $joparams = array(
            'apiToken'=>$apiToken,
            'follower'=>$follower->id,
            'user'=>$user->id,
        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('startFollowUser', $job);
        }
        catch(\Exception $e){

        }
        
    }


    /**
     * @param Talk $talk
     * @param User $user
     * @param ApiToken $apiToken
     */
    public static function talkLiked($talk,$user,$apiToken){

         $joparams = array(
             'apiToken'=>$apiToken,
             'talk'=>$talk->id,
             'user'=>$user->id,
             'curent_user'=>\Yii::$app->user->id,
             
         );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('talkLiked', $job);
        }
        catch(\Exception $e){
           
        }
        



    }


    /**
     * @param FreeTalkMessage $message
     * @param $user
     * @param $messageObj
     * @param $apiToken
     */

    public static function freeTalkImageMessageSent($message,$user,$messageObj,$apiToken){

        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['message'=>$messageObj]);
        $redis->executeCommand('publish', ['free_talk_'.$message->talk_id, 'php/o:'.$sendMessage.'']);

        $joparams = array(
            'apiToken'=>$apiToken,
            'talk_id'=>$message->talk_id,
            'message'=>$message->getMessageJson(),

        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('freeTalkImageSend', $job);
        }
        catch(\Exception $e){

        }



    }

    public static function userMessageSent($message,$user,$messageObj,$apiToken){

        $redis = \Yii::$app->redis_db;


        $sendMessage =json_encode(['message'=>$messageObj]);
        $redis->executeCommand('publish', ['spot_talk_'.$message->talk_id, 'php/o:'.$sendMessage.'']);

        $joparams = array(
            'apiToken'=>$apiToken,
            'talk_id'=>$message->talk_id,
            'message'=>$message->getMessageJson(),

        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('talkSendSpot', $job);
        }
        catch(\Exception $e){

        }


    }

    public static function spotMessageSent($message,$user,$messageObj,$apiToken){


        $redis = \Yii::$app->redis_db;


        $sendMessage =json_encode(['message'=>$messageObj]);
        $redis->executeCommand('publish', ['spot_talk_'.$message->talk_id, 'php/o:'.$sendMessage.'']);

        $joparams = array(
            'apiToken'=>$apiToken,
            'talk_id'=>$message->talk_id,
            'message'=>$message->getMessageJson(),

        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('talkSendSpot', $job);
        }
        catch(\Exception $e){

        }




    }

    /**
     * @param Message $message
     * @param $user
     * @param $messageObj
     * @param $apiToken
     */

    public static function imageMessageSent($message,$user,$messageObj,$apiToken){

        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['message'=>$messageObj]);
         $redis->executeCommand('publish', ['spot_talk_'.$message->talk_id, 'php/o:'.$sendMessage.'']);

        $joparams = array(
            'apiToken'=>$apiToken,
            'talk_id'=>$message->talk_id,
            'message'=>$message->getMessageJson(),

        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('talkImageSend', $job);
        }
        catch(\Exception $e){

        }



    }

    /**
     * @param PrivateMessage $message
     * @param $user
     * @param $messageObj
     * @param $apiToken
     */
    public static function privateImageMessageSent($message,$user,$messageObj,$apiToken){

        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['message'=>$messageObj]);
        $redis->executeCommand('publish', ['private_talk_'.$message->talk_id, 'php/o:'.$sendMessage.'']);



        $joparams = array(
            'apiToken'=>$apiToken,
            'talk_id'=>$message->talk_id,
            'message'=>$message->getMessageJson(),

        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('privateTalkImageSend', $job);
        }
        catch(\Exception $e){

        }


    }




    public static function receivedPrivateMessageReport($message,$report,$user,$apiToken)
    {





    }

    public static function receivedFreeTalkMessageReport($message,$report,$user,$apiToken)
    {





    }

    

    public static function receivedMessageReport($message,$report,$user,$apiToken)
    {





    }

    /**
     * @param Coin $talant
     * @param User $fromUser
     * @param User $toUser
     * @param ApiToken $apiToken
     */
    public static function talantGranted($talant,$fromUser,$toUser,$apiToken){



        $joparams = array(
            'apiToken'=>$apiToken,
            'talant'=>$talant->id,
            'toUser'=>$toUser->id,
        );

        
        if (isset($fromUser)){

            $joparams['fromUser']=$fromUser->id;
        }else
        {
            $joparams['fromUser']=false;
        }

        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('talantGranted', $job);
        }
        catch(\Exception $e){

        }

        

        

    }

    public static function userCheckedIn($spot,$latitude,$longitude,$apiToken){



        /**
         * This is the model class for table "coin".
         *
         * @property integer $id
         * @property integer $creator_id
         * @property integer $create_reason
         * @property integer $status
         * @property string $created_at
         * @property string $updated_at
         * @property string $transfer_date
         * @property integer $owner_reason
         * @property integer $coin_type
         * @property integer $cover_type
         * @property integer $coupon_id
         * @property integer $current_user_owner_id
         * @property integer $current_spot_owner_id
         * @property integer $obtained_in_spot_id
         * @property integer $obtained_in_talk_id
         * @property integer $obtained_for_message_id
         * @property double $current_lat
         * @property double $current_lng
         * @property string $current_location
         */


        if (!UserTask::find()->where(['user_id'=>\Yii::$app->user->id,'type'=>UserTask::TYPE_CREATE_RTH])->exists()){


            $newTask = UserTask::getForRTH();
            $newTask->uuid =  Uuid::uuid1()->toString();
            $newTask->user_id=\Yii::$app->user->id;
            $newTask->status=UserTask::STATUS_DONE;


            if ($newTask->save()){


                self::taskDone($newTask->uuid,\Yii::$app->user->id,$apiToken);
            }



        }


    }

    public static function taskDone($task_uuid,$user_id,$apiToken=null){



        $joparams = array(
            'user'=>$user_id,
            'task_uuid'=>$task_uuid,
        );


        if (isset($apiToken)){

            $joparams['apiToken']=$apiToken;
        }

        \Yii::warning("rr");
        try {

            $job = new JobWorkload([
                'params'
                => $joparams
            ]);

            \Yii::$app->gearman->getDispatcher()->background('taskDone', $job);
            
            
        }
        catch(\Exception $e){

        }


        
    }


    public static function userRegisteredByFacebook($user,$facebook_id,$facebook_token,$apiToken){

        $joparams = array(
            'apiToken'=>$apiToken,
            'facebook_id'=>$facebook_id,
            'facebook_token'=>$facebook_token,
            'user'=>$user->id,
        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('userRegisteredByFacebook', $job);
        }
        catch(\Exception $e){

        }

    }
    
    public static function userRegistered($user,$registration_type,$apiToken){

       
        
    }

    public static function couponActivated ($user,$coupon,$apiToken){


    }

    /**
     * @param $talk
     * @param User $user
     * @param $apiToken
     */


    public static function userLeaveFreeTalk($talk,$user,$apiToken){


        $user->unlink('followingFreeTalks',$talk,true);
        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['notification'=>['code'=>self::TYPE_LEAVE_TALK,'user'=>$user->id]]);
        $redis->executeCommand('publish', ['free_talk_'.$talk->id, 'php/o:'.$sendMessage.'']);





    }



    /**
     * @param $talk
     * @param User $user
     * @param $apiToken
     */


    public static function userLeaveTalk($talk,$user,$apiToken){


        $user->unlink('followingTalks',$talk,true);
        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['notification'=>['code'=>self::TYPE_LEAVE_TALK,'user'=>$user->id]]);
        $redis->executeCommand('publish', ['spot_talk_'.$talk->id, 'php/o:'.$sendMessage.'']);





    }


    /**
     * @param FreeTalk $talk
     * @param User $user
     * @param $apiToken
     */
    public static function userJoinedFreeTalk($talk,$user,$apiToken){


        try{
            $user->link('followingFreeTalks',$talk,['last_connect'=>new Expression('now()'),'is_active'=>true]);
        }catch (\Exception $e){

            $connection = \Yii::$app->getDb();
            $command = $connection->createCommand('UPDATE "free_talk_participants" SET ("last_connect", "is_active") = (now(), TRUE) WHERE user_id = :user_id and talk_id=:talk_id', [':talk_id' => $talk->id,':user_id'=>\Yii::$app->user->id]);
            $command->execute();

        }





        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['notification'=>['code'=>self::TYPE_JOIN_TALK,'user'=>$user->getUserMidi()]]);
        $redis->executeCommand('publish', ['free_talk_'.$talk->id, 'php/o:'.$sendMessage.'']);
    }

    
    
    /**
     * @param $talk
     * @param User $user
     * @param $apiToken
     */
    public static function userJoinedTalk($talk,$user,$apiToken){


        try{
            $user->link('followingTalks',$talk,['last_connect'=>new Expression('now()'),'is_active'=>true]);
        }catch (\Exception $e){

            $connection = \Yii::$app->getDb();
            $command = $connection->createCommand('UPDATE "talk_participants" SET ("last_connect", "is_active") = (now(), TRUE) WHERE user_id = :user_id and talk_id=:talk_id', [':talk_id' => $talk->id,':user_id'=>\Yii::$app->user->id]);
            $command->execute();

        }





        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['notification'=>['code'=>self::TYPE_JOIN_TALK,'user'=>$user->getUserMidi()]]);
        $redis->executeCommand('publish', ['spot_talk_'.$talk->id, 'php/o:'.$sendMessage.'']);
    }

    /**
     * @param $talk
     * @param User $user
     * @param $apiToken
     */
    public static function userJoinedPrivateTalk($talk,$user,$apiToken){


        try{

            $talk->link('users',$user,['last_connect'=>new Expression('now()'),'participant_status'=>PrivateTalk::STATUS_ACTIVE]);

        }catch (\Exception $e){

            $connection = \Yii::$app->getDb();
            $command = $connection->createCommand('UPDATE "private_talk_participants" SET ("last_connect", "participant_status") = (now(), :status) WHERE user_id = :user_id and private_talk_id=:talk_id', [':talk_id' => $talk->id,':user_id'=>\Yii::$app->user->id,':status'=>PrivateTalk::STATUS_ACTIVE]);
            $command->execute();

        }





        $redis = \Yii::$app->redis_db;

        $sendMessage =json_encode(['notification'=>['code'=>self::TYPE_JOIN_TALK,'user'=>$user->getUserMidi()]]);
        $redis->executeCommand('publish', ['spot_talk_'.$talk->id, 'php/o:'.$sendMessage.'']);
    }

    /**
     * @param Talk $talk
     * @param $fb_user_id
     * @param $fb_token
     * @param $tw_user_id
     * @param $tw_token
     * @param $tw_token_secret
     * @param $apiToken
     */
    public static function talkCreated ($talk,$fb_user_id,$fb_token,$tw_user_id,$tw_token,$tw_token_secret,$apiToken){


        preg_match_all('/#([\p{L}\p{Mn}\p{N}]+)/u', $talk->description, $matches);


        
        
        
        $talk_hashtags = $matches[1];




        if($talk->createdBy){


            $talk->createdBy->link('followingTalks',$talk,['last_connect'=>new Expression('now()'),'is_active'=>false]);


            if($talk->file_name){


                $pictureMessage= new Message();
                $pictureMessage->talk_id=$talk->id;
                $pictureMessage->timestamp=microtime(true);
                $pictureMessage->user_id=$talk->createdBy->id;
                $pictureMessage->message_picture = \Yii::$app->user->id . "_" . uniqid() .$talk->file_name;
                copy($talk->uploadTo('file_name'), MyFileSystem::makeDirs($pictureMessage->uploadTo('message_picture')));
                $pictureMessage->save();
            }

            $firstMessage= new Message();
            $firstMessage->message_text = $talk->description;
            $firstMessage->talk_id=$talk->id;
            $firstMessage->user_id=$talk->createdBy->id;
            $firstMessage->timestamp=microtime(true);
            $firstMessage->save();


        }



        foreach($talk_hashtags as $talk_hashtag){

            $hashtag = Hashtag::find()->where(['tag'=>$talk_hashtag])->one();

            if($hashtag){
                $hashtag->link('talks',$talk);
            }

            if(!$hashtag){
                $hashtag=new Hashtag();
                $hashtag->tag= $talk_hashtag;
                if($hashtag->save())
                {
                    $hashtag->link('talks',$talk);
                }

            }


        }

        if (!UserTask::find()->where(['user_id'=>\Yii::$app->user->id,'type'=>UserTask::TYPE_CREATE_TALK])->exists()){


            $newTask = UserTask::getForTalk();
            $newTask->user_id=\Yii::$app->user->id;
            $newTask->status=UserTask::STATUS_DONE;


            if ($newTask->save()){


                self::taskDone(\Yii::$app->user->id,$apiToken);
            }



        }




        $joparams = array(
            'apiToken'=>$apiToken,
            'talk'=>$talk->id,
            'fb_user_id'=>$fb_user_id,
            'fb_token'=>$fb_token,
            'tw_user_id'=>$tw_user_id,
            'tw_token'=>$tw_token,
            'tw_token_secret'=>$tw_token_secret,
        );


        try {
            $job = new JobWorkload([
                'params'
                => $joparams
            ]);


            \Yii::$app->gearman->getDispatcher()->background('talkCreated', $job);
        }
        catch(\Exception $e){

        }
        
        

    }





}