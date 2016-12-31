<?php
namespace Catrobat\AppBundle\Listeners\View;

use Catrobat\AppBundle\Entity\TemplateManager;
use Catrobat\AppBundle\Responses\TemplateListResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Catrobat\AppBundle\Responses\ProgramListResponse;
use Catrobat\AppBundle\Services\ScreenshotRepository;
use Symfony\Component\HttpFoundation\Request;
use Catrobat\AppBundle\Services\Formatter\ElapsedTimeStringFormatter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Router;

class TemplateListSerializer
{
    private $request_stack;
    private $template_path;
    private $screenshot_repository;
    private $time_formatter;
    
    public function __construct(RequestStack $request_stack, $template_path, ScreenshotRepository $screenshot_repository, ElapsedTimeStringFormatter $time_formatter)
    {
        $this->request_stack = $request_stack;
        $this->template_path = $template_path;
        $this->screenshot_repository = $screenshot_repository;
        $this->time_formatter = $time_formatter;
    }
    
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $result = $event->getControllerResult();
        if (! ($result instanceof TemplateListResponse)) {
            return;
        }
        
        $templates = $result->getTemplates();
        $request = $this->request_stack->getCurrentRequest();
        
        $retArray = array();
        $retArray['CatrobatTemplates'] = array();
        if($templates != null) {
            foreach ($templates as $template) {
                $new_template = array();
                $new_template['id'] = $template->getId();
                $new_template['name'] = $template->getName();
                $new_template['thumbnail'] = $this->screenshot_repository->getThumbnailWebPath($template->getId());
                $new_template['landscape'] = $this->generateUrl($template->getId());
                $new_template['portrait'] = $this->generateUrl($template->getId(), false);
                $retArray['CatrobatTemplates'][] = $new_template;
            }
        }
        $retArray['completeTerm'] = '';
        $retArray['preHeaderMessages'] = '';
        
        $retArray['CatrobatInformation'] = array(
            'BaseUrl' => ($request->isSecure() ? 'https://' : 'http://') . $request->getHttpHost() . '/',
            'ProjectsExtension' => '.catrobat'
        );
        
        $event->setResponse(JsonResponse::create($retArray));
    }
    
    public function generateUrl($id, $landscape = true)
    {
        $prefix = TemplateManager::PORTRAIT_PREFIX;
        if($landscape)
            $prefix = TemplateManager::LANDSCAPE_PREFIX;
        return ltrim($this->template_path . $prefix . $id . '.catrobat', '/');
    }
}