<?php

namespace Ramapriya\SlimPack\Tools\Settings;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Request;
use CAdminTabControl;
use Ramapriya\SlimPack\Interfaces\ModuleInterface;

Loc::loadMessages(__FILE__);

class Renderer implements ModuleInterface
{

    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getTabs(): array
    {
        return [

            [
                'DIV' => 'main_settings',
                'TAB' => Loc::getMessage('main_settings_tab'),
                'OPTIONS' => [
                    Loc::getMessage('label_notification'),
                    [
                        'slim_application_path',
                        Loc::getMessage('label_slim_application_path'),
                        '',
                        ['text']
                    ],
                    [
                        'slim_urlrewriter_condition',
                        Loc::getMessage('label_slim_urlrewriter_condition'),
                        '',
                        ['text']
                    ],
                    [
                        'routes_file_path',
                        Loc::getMessage('label_routes_file_path'),
                        '',
                        ['text']
                    ]
                ]
            ]
        ];
    }

    public function render()
    {
        $tabControl = new CAdminTabControl('tabControl', $this->getTabs());

        $tabControl->Begin();
        $this->formStart();

        foreach ($this->getTabs() as $tab) {
            if (! empty($tab['OPTIONS'])) {
                $tabControl->BeginNextTab();
                __AdmSettingsDrawList(self::MODULE_ID, $tab['OPTIONS']);
                $tabControl->EndTab();
            }
        }

        $tabControl->Buttons([
            'buttons' => [
                'btnSave'  => true,
                'btnApply' => true,
            ],
        ]);
        $this->formEnd();
        $tabControl->End();
    }

    private function getFormActionUrl(): string
    {
        return sprintf(
            '%s?%s',
            $this->request->getRequestedPage(),
            http_build_query([
                'mid'  => self::MODULE_ID,
                'lang' => LANGUAGE_ID,
            ])
        );
    }

    public function formStart(): void
    {
        echo sprintf(
            '<form action="%s" method="post">',
            $this->getFormActionUrl()
        );
        echo bitrix_sessid_post();
    }

    public function formEnd()
    {
        echo '</form>';
    }
}
