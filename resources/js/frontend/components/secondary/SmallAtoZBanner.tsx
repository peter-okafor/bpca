import { ArrowNarrowRightIcon } from "@heroicons/react/solid";
import { Inertia } from "@inertiajs/inertia";
import { FC, HTMLAttributes } from "react";

interface SmallAtoZBannerProps extends HTMLAttributes<HTMLDivElement> {
    className?: string;
}

export const SmallAtoZBanner:FC<SmallAtoZBannerProps> = ({
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
        <p className='py-3 font-black text-3xl h-full'>
            <span className='inline'>A</span>
            <ArrowNarrowRightIcon className='h-4 w-4 inline' />
            <span className='inline pr-1.5'>Z</span>
            <span className='inline text-2xl'>of Pests</span>
        </p>
    </div>
)   