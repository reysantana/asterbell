<?php

namespace App\Http\Resources;

use App\Models\NotificationTemplate;
use Illuminate\Http\Resources\Json\Resource;

class NotificationResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      if (!isset($this->id)) {
        return null;
      }

      $template = NotificationTemplate::find($this->notification_template_id);

      $fullMessage = $template->message_content;
      if ($template->category === 'reward') {
        $fullMessage = str_replace('{{SERIAL_CODE}}', $this->submission->reward()->serial_code, $template->message_content);
      }

      return [
        'id' => $this->id,
        'category' => $template->category,
        'excerpt' => $template->message_excerpt,
        'content' => $fullMessage,
        'date' => (string)$this->created_at,
      ];
    }
}
