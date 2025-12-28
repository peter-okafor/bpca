import { FC, HTMLAttributes } from "react";
import { Image } from "../primary/Image";

interface AccreditationDateProps extends HTMLAttributes<HTMLElement> {
    accreditation_year: string;
}

export const AccreditationDate: FC<AccreditationDateProps> = ({
    accreditation_year
}) => {
    return (
        <>
        {accreditation_year && (
            <div className="rounded-md bg-pest-aliceblue flex flex-row w-full py-7 px-9 mt-8">
                <Image className="w-20 rounded-full" src="/images/BPCA-member-logo-400-400.png" alt='provider logo'/>
                <h4 className="font-semibold text-xl px-[15px] text-[#F62F56]">ACCREDITED MEMBER SINCE {accreditation_year} </h4>
            </div>
        )}
        </>
    )
}