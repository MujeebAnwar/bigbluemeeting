<?php


namespace App\bigbluebutton\src\Parameters;
use BigBlueButton\Parameters\CreateMeetingParameters as BaseCreateMeetingParameters;

class CreateMeetingParameters extends BaseCreateMeetingParameters
{
    const ALWAYS_ACCEPT = 'ALWAYS_ACCEPT';
    const ALWAYS_DENY   = 'ALWAYS_DENY';
    const ASK_MODERATOR = 'ASK_MODERATOR';


    private $guestPolicy = self::ALWAYS_ACCEPT;

    /**
     * @return bool
     */
    public function isBlockedJoin()
    {
        return $this->guestPolicy === self::ALWAYS_DENY;
    }

    public function setBlockedJoin()
    {
        $this->guestPolicy = self::ALWAYS_DENY;

        return $this;
    }

    /**
     * @return bool
     */
    public function isModerateJoin()
    {
        return $this->guestPolicy === self::ASK_MODERATOR;
    }

    public function setModerateJoin()
    {
        $this->guestPolicy = self::ASK_MODERATOR;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOpenJoin()
    {
        return $this->guestPolicy === self::ALWAYS_ACCEPT;
    }

    public function setOpenJoin()
    {
        $this->guestPolicy = self::ALWAYS_ACCEPT;

        return $this;
    }

    /**
     * @return string
     */
    public function getGuestPolicy()
    {
        return $this->guestPolicy;
    }

    public function getHTTPQuery()
    {
        $arr = parent::getHTTPQuery();


        $arr .= '&guestPolicy='.$this->guestPolicy;



        return $arr;


         // TODO: Change the autogenerated stub

    }


}