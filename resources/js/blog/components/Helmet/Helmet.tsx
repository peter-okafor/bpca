import { Head } from '@inertiajs/inertia-react';
import React, {FC} from 'react';

interface HelmetProps {
    children: React.ReactNode[] | React.ReactNode;
}

export const Helmet: FC<HelmetProps> = ({
    ...props
}) => {
    // const { title } = props.children;

    return (
        <Head title={props.children as string} />
    );
}