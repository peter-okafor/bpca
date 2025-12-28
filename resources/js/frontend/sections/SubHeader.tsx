import { Inertia } from '@inertiajs/inertia';
import { useRemember } from '@inertiajs/inertia-react';
import React, { useEffect, useState } from 'react';
import api from '../api';
import { Button, Input, InputGroup, MyComboBox } from '../components';
import { Pest } from '../data/models';

interface SubHeaderProps extends React.HTMLAttributes<HTMLDivElement> {
    title?: string;
}

export const SubHeader: React.FC<SubHeaderProps> = ({
    title = true,
    className,
    ...props
}) => {

    return (
        <section className={`w-full 
        bg-gradient-to-r from-pest-search-purple to-pest-search-rose 
        px-container_others lg:px-container_lg md:px-container_md sm:px-container_sm 
        sm:py-6 md:py-10 lg:py-10 py-6
        block lg:grid md:grid sm:block
        lg:grid-cols-3 md:grid-cols-3
        gap-x-20' ${className}`} {...props} />
    )
}