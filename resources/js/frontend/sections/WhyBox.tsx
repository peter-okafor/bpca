import { FC } from "react"
import { CheckList } from "../components"
import { ComponentContentType } from "../data/models"

interface WhyBoxProps {
    benefits: ComponentContentType;
}

export const WhyBox: FC<WhyBoxProps> = ({
    benefits
}) => {
    return (
        <div className='w-full bg-pest-aliceblue grid grid-cols-1 px-4 py-6 lg:grid-cols-3 lg:px-[14.5%] lg:py-24'>
            <div className='pr-0 lg:col-span-2 lg:pr-14'>
                <h3 className='font-semibold text-2xl text-pest-cyprus pb-10 text-center lg:text-left'>Why use pests.org?</h3>
                <p>{benefits.content}</p>
            </div>
            <div className='lg:col-span-1'>
                <ul className='font-semibold text-xl pt-8'>
                    <CheckList>Checked and assessed</CheckList>
                    <CheckList>Operates nationwide</CheckList>
                    <CheckList>Reviewed by you</CheckList>
                </ul>
            </div>
        </div>
    )
}