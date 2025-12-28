import { ArrowNarrowRightIcon } from "@heroicons/react/solid";
import { Inertia } from "@inertiajs/inertia";
import { FC, HTMLAttributes } from "react";

interface AtoZBannerProps extends HTMLAttributes<HTMLDivElement> {
    className?: string;
}

export const AtoZBanner:FC<AtoZBannerProps> = ({
    className,
    ...props
}) => (
    <div
        className={
            `bg-atoz 
            bg-no-repeat 
            bg-center 
            bg-cover 
            bg-origin-border 
            rounded-lg 
            w-full 
            h-16 
            text-center 
            text-white 
            overflow-hidden 
            py-auto 
            cursor-pointer
            ${className || ""}`
        }
        onClick={() => Inertia.visit('/pests')}
        {...props}
    >
        <p className='py-8 font-black text-6xl h-full'>
            <span className='inline'>A</span>
            <ArrowNarrowRightIcon className='h-4 w-4 inline' />
            <span className='inline pr-1.5'>Z</span>
            <span className='inline text-3xl'>of Pests</span>
        </p>
    </div>
)   