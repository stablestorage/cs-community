<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\Event\Event;

/**
 * ChatMessages Controller
 *
 * @property \App\Model\Table\ChatMessagesTable $ChatMessages
 */
class ChatMessagesController extends AppController
{

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow('new');
        parent::beforeFilter($event);
    }

    /**
     * New method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function new()
    {
        $chatMessage = $this->ChatMessages->newEntity();
        $this->request->data['sent_by'] = $this->Auth->user('steam_id');
        $this->request->data['personaname'] = $this->Auth->user('personaname');
        if ($this->request->is('post')) {
            $chatMessage = $this->ChatMessages->patchEntity($chatMessage, $this->request->data);
            if ($this->ChatMessages->save($chatMessage)) {
                // websocket
                $context = new \ZMQContext();
                $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'Pusher');
                $socket->connect("tcp://localhost:5555");
                $this->request->data['topic'] = 'new_chat_message';
                $socket->send(json_encode($this->request->data));
                // end
                return;
            } else {
                $this->Flash->error(__('The chat message could not be saved. Please, try again.'));
            }
        }
    }

    /**
     * Delete method
     *
     * @param string|null $id Chat Message id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $chatMessage = $this->ChatMessages->get($id);
        if ($this->ChatMessages->delete($chatMessage)) {
            $this->Flash->success(__('The chat message has been deleted.'));
        } else {
            $this->Flash->error(__('The chat message could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
