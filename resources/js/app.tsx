import './bootstrap';
import React, { Suspense } from 'react';
import { render } from 'react-dom';
import { createInertiaApp } from '@inertiajs/inertia-react';
import { InertiaProgress } from '@inertiajs/progress';
import { Provider } from 'react-redux';
import { store } from './blog/app/store';


const RtlImportCssLazy = React.lazy(() => import("./blog/RtlImportCss"));

document
  .getElementsByTagName("html")[0]
  .setAttribute("dir", process.env.MIX_LRT_OR_RTL as string);

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.tsx`),
    setup({ el, App, props }) {
        return render(
            <Provider store={store}>
                <App {...props} />
                <Suspense fallback={<div />}>
                    <RtlImportCssLazy />
                </Suspense>
            </Provider>
            , el
        );
    },
});

InertiaProgress.init({ color: '#4B5563' });
