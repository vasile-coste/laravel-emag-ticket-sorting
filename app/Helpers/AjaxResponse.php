<?php

namespace App\Helpers;

class AjaxResponse
{
    /**
     * @var string
     */
    private $location = "/";

    /**
     * @var string
     */
    private $message = "Something went wrong.";

    /**
     * @var bool
     */
    private $success = false;

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param array $data
     * 
     * @return AjaxResponse
     */
    public function setData(array $data): AjaxResponse
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param bool $success
     * 
     * @return AjaxResponse
     */
    public function setSuccess(bool $success): AjaxResponse
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @param string $message
     * 
     * @return AjaxResponse
     */
    public function setMessage(string $message): AjaxResponse
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param arrau $messages
     * 
     * @return AjaxResponse
     */
    public function setMessages(array $messages): AjaxResponse
    {
        $this->message = implode("\n", array_filter($messages));
        return $this;
    }

    /**
     * @param string $location
     * 
     * @return AjaxResponse
     */
    public function setLocation(string $location): AjaxResponse
    {
        $this->location = $location;
        return $this;
    }

    /**
     * @param int $options
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode([
            'success' => $this->success,
            'message' => $this->message,
            'location' => $this->location,
            'data' => $this->data
        ]);
    }
}
